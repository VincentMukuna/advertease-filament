<?php

namespace App\Filament\Reports;

use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use EightyNine\Reports\Components\Text;
use EightyNine\Reports\Report;
use Filament\Forms\Form;

class UsersReport extends Report
{
    public ?string $heading = 'Users Report';

    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        return $header
            ->schema([
                Header\Layout\HeaderRow::make()
                    ->schema([
                        Header\Layout\HeaderColumn::make()
                            ->schema([
                                Text::make('User registration report')
                                    ->title()
                                    ->primary(),
                                Text::make('A user registration report')
                                    ->subtitle(),
                            ]),
                        //                                          Header\Layout\HeaderColumn::make()
                        //                                              ->schema([
                        //                                                           Image::make($imagePath),
                        //                                                       ])
                        //                                              ->alignRight(),
                    ]),
            ]);
    }

    public function body(Body $body): Body
    {
        return $body
            ->schema([

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
