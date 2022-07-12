<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $minTtl = Link::MIN_TTL;
        $maxTtl = Link::MAX_TTL;
        $minUsage = Link::MIN_USAGE;
        $maxUsage = Link::MAX_USAGE;

        return [
            'link' => [
                'required',
                'url',
            ],
            'usageLimit' => [
                'required',
                'numeric',
                "min:$minUsage",
                "max:$maxUsage",
            ],
            'ttl' => [
                'required',
                'numeric',
                "min:$minTtl",
                "max:$maxTtl",
            ],
        ];
    }
}
