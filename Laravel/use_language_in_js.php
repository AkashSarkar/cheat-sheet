Route::get('/js/lang.js', function () {
    $strings = Lang::get('*');
    $script = "export const lang=";
    $script .= json_encode($strings, JSON_PRETTY_PRINT);
    $fileName = "../resources/assets/js/lang.js";
    file_put_contents($fileName, $script);
    dd($strings);
})->name('assets.lang');