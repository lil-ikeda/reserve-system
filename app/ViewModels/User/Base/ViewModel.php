<?php
declare(strict_types=1);

namespace App\ViewModels\User\Base;

use Illuminate\Contracts\Support\Arrayable;

abstract class ViewModel implements Arrayable
{
    /**
     * データをキーバリューのarrayに変換
     * @return array
     */
    abstract public function toMap(): array;

    /**
     * 再帰的にarrayに変換
     * @return array
     */
    final public function toArray()
    {
        $result = $this->toMap();
        foreach ($result as $key => $value) {
            if ($value instanceof Arrayable) {
                $result[$key] = $value->toArray();
            } elseif (is_array($value)) {
                $result[$key] = collect($value)->toArray();
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}