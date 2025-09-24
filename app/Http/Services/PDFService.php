<?php

namespace App\Http\Services;

use App\Models\Settings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as httpResponse;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Settings\Entities\GeneralSettings;

class PDFService
{

    /* private $user = null;

    public static function init(): PDFService
    {
        return new self;
    }

    public function authenticate(): PDFService
    {
        return $this;
    }
 */
    public function prepare($template, $data, $pdfFileName,  $landscape = null , $footer = null , $preview = null , $size = null): httpResponse
    {

        $html = view($template)->with($this->getMergedDate($data))->render();

        if ($preview == "true") {
            return Response::make($this->prepareContent($html, $landscape , $footer), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $pdfFileName . '"',
            ]);
        } else {
            return Response::make($this->prepareContent($html, $landscape , $footer), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $pdfFileName . '"',
            ]);
        }

    }

    private function prepareContent($html, $landscape = null  , $footer = null , $size = null): string
    {
        $pdf = Pdf::loadHTML($html);

        if ($landscape) {
            if(!empty($size))
            {
                $pdf->setPaper($size, 'landscape');
            }else{

                $pdf->setPaper('A4', 'landscape');
            }
        }

        $pdf->setCallbacks([
            'text' => function ( $text) {
                $pageNumber = $text->get_page_number();
                $totalPages = $text->get_page_count();

                // Custom HTML content for the page text
                $html = '<div style="text-align: center;">Page ' . $pageNumber . ' of ' . $totalPages . '</div>';

                $text->set_text($html);
            }
        ]);

        return $pdf->output();
        
    }

    private function getMergedDate($data): array
    {
        return array_merge($data, [
            'user' => auth()->user()->name,
            'settings' => $this->getGlobalSettings()
        ]);
    }

    private function getGlobalSettings(): array
    {
        $settings = new Settings();
        return [
            'name' => $settings->getSettings('store-name'),
            'phone' => $settings->getSettings('store-first-phone'),
            'second-phone' => $settings->getSettings('store-second-phone'),
            'logo' => $settings->getSettings('store-logo'),
        ];
    }

    
}
