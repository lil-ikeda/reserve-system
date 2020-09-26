<?php

namespace App\ViewModels\Base;

use Illuminate\View\View;

abstract class ViewModel
{
    /**
     * データをマッピング
     *
     * @return array
     */
    abstract protected function toMap(): array;

    /**
     * 描画
     *
     * @param string $view
     * @return View
     */
    final public function render(string $view): View
    {
        return view($view, $this->toMap());
    }
}
