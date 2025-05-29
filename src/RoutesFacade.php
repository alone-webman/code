<?php

namespace AloneWebMan\Code;

use Webman\Route;

class RoutesFacade {
    /**
     * @param bool|null $status
     * @return void
     */
    public static function favicon(bool|null $status): void {
        $status
        && Route::any('/favicon.ico', function() {
            return response();
        })->name('favicon');
    }

    /**
     * @param bool|null $status
     * @return void
     */
    public static function robots(bool|null $status): void {
        $status
        && Route::any('/robots.txt', function() {
            return response("User-agent: *\r\nDisallow: /", 200, ['Content-Type' => 'text/plain']);
        })->name('robots');
    }

    /**
     * @param bool|null     $status
     * @param callable|null $callback
     * @return void
     */
    public static function back(bool|null $status, callable|null $callback = null): void {
        $callback = ($callback ?: (function() {
            $request = request();
            if ($request->method() == 'OPTIONS') {
                return response('');
            }
            return $request->expectsJson() ? json(['code' => 404, 'msg' => '404 not found']) : alone_error_html();
        }));
        if ($status === true) {
            Route::any('[{path:.+}]', $callback);
        } elseif ($status === false) {
            $status && Route::fallback($callback);
        }
    }
}


/*

// 禁用主项目默认路由，不影响应用插件
Route::disableDefaultRoute();

// 禁用主项目的admin应用的路由，不影响应用插件
Route::disableDefaultRoute('', 'admin');

// 禁用foo插件的默认路由，不影响主项目
Route::disableDefaultRoute('foo');

// 禁用foo插件的admin应用的默认路由，不影响主项目
Route::disableDefaultRoute('foo', 'admin');

// 禁用控制器 [\app\controller\IndexController::class, 'index'] 的默认路由
Route::disableDefaultRoute([\app\controller\IndexController::class, 'index']);


// 匹配 /user/123, 不匹配 /user/abc
Route::any('/user/{id:\d+}', function (Request $request, $id) {
    return response($id);
});

// 匹配 /user/foobar, 不匹配 /user/foo/bar
Route::any('/user/{name}', function (Request $request, $name) {
   return response($name);
});

// 匹配 /user /user/123 和 /user/abc   []表示可选
Route::any('/user[/{name}]', function (Request $request, $name = null) {
   return response($name ?? 'tom');
});

// 匹配 任意以/user/为前缀的请求
Route::any('/user/[{path:.+}]', function (Request $request) {
    return $request->path();
});

// 匹配所有options请求   :后填写正则表达式，表示此命名参数的正则规则
Route::options('[{path:.+}]', function () {
    return response('');
});
 */