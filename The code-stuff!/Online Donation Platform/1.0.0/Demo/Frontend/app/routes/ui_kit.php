<?php

Route::get('/ui-kit', function() {
	return view('ui_kit');
})->name('ui_kit');

Route::get('/ui-kit/fontawesome-cheatsheet', function() {
	return view('ui_kit_fa_cheatsheet');
})->name('ui_kit_fontawesome_cheatsheet');
