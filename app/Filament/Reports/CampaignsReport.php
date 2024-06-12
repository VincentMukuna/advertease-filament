<?php

namespace App\Filament\Reports;

use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use EightyNine\Reports\Components\Text;
use EightyNine\Reports\Report;
use Filament\Forms\Form;

class CampaignsReport extends Report
{
    public ?string $heading = 'Campaigns Report';

    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        return $header
            ->schema([
                Header\Layout\HeaderColumn::make()
                    ->schema([
                        Text::make('Cammpaigns report')
                            ->title()
                            ->primary(),
                        Text::make('A report detailing campaign performance')
                            ->subtitle(),
                    ]),
            ]);
    }

    public function body(Body $body): Body
    {
        return $body
            ->schema([
                // ...
            ]);
    }

    public function footer(Footer $footer): Footer
    {
        return $footer
            ->schema([
                // ...
            ]);
    }

    public function filterForm(Form $form): Form
    {
        return $form
            ->schema([
                // ...
            ]);
    }
}
