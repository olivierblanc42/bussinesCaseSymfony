<?php

namespace App\Twig;

use App\Service\NumberConverterService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;




class AppStarsCardExtension extends AbstractExtension
{
    public function __construct(
        private NumberConverterService $converterService
    ) { }


    public function getFilters(): array
    {
        return [
            new TwigFilter('number_converter', [$this, 'getNumberConverter']),
        ];
    }



    public function getNumberConverter( string $moyenne): string
    {
        return  $this->converterService->notefilter($moyenne);
    }
}
