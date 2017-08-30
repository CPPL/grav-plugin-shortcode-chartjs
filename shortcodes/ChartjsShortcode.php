<?php

namespace Grav\Plugin\Shortcodes;

use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class ChartjsShortcode extends Shortcode
{
    private $pluginConfig;
    private $defCanvas;
    private $defWidth;
    private $defHeight;
    private $backgroundcolor;
    private $bordercolor;

    public function init()
    {
        $this->shortcode->getHandlers()->add('chartjs', function(ShortcodeInterface $sc) {
            // Get plugin settings
            $this->pluginConfig    = $this->config->get('plugins.shortcode-chartjs');
            $this->defCanvas       = $this->pluginConfig['canvas']['name'];
            $this->defWidth        = $this->pluginConfig['canvas']['width'];
            $this->defHeight       = $this->pluginConfig['canvas']['height'];
            $this->backgroundcolor = $this->pluginConfig['chart']['bkgndcolor'];
            $this->bordercolor     = $this->pluginConfig['chart']['bordercolor'];

            // Get shortcode settings
            /** Example shortcode block
             *
             * [chartjs name="availability" width="100" height="100" type="pie" label="Studio Utilisation"
             * datapoints="55,176" datalabels="Booked, Available" backgroundcolor1="rgba(255, 99, 132, 0.2)"
             * backgroundcolor2="rgba(54, 162, 235, 0.2)" bordercolor1="rgba(255,99,132,1)"
             * bordercolor2="rgba(54, 162, 235, 1)" borderwidth="1"][/chartjs]
             *
             */

            // @todo: Add support for data and config from URL/path

            // Add our canvas
            $output = $this->buildCanvas($sc);

            // Configure our JS
            $this->shortcode->addAssets('js', '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js');
            $chartjs = $this->buildChartJS($sc);
            $output = $output . "<script>$chartjs</script>";


            // Return canvas etc
            return $output;
        });
    }

    private function assembleValues(ShortcodeInterface $sc, $name, $numberOfDataPoints)
    {
        if (is_null($sc) || !is_numeric($numberOfDataPoints) || $numberOfDataPoints == 0)
        {
            return '';
        }

        $defaultValue = $sc->getParameter($name, $this->$name);

        $values = [];

        for ($i = 1; $i <= $numberOfDataPoints; $i++)
        {
            $paramName = $name . $i;
            $color = $sc->getParameter($paramName, $defaultValue);
            $values[] = $color;
        }

        $values = $this->convertArrayToJSRepresentation($values);

        return $values;
    }

    private function convertArrayToJSRepresentation($values)
    {
        if (count($values) > 0)
        {
            $jsStringLiteralArray = '[\'' . implode("','", $values) . '\']';
        } else {
            $jsStringLiteralArray = "[]";
        }

        return $jsStringLiteralArray;
    }

    private function buildChartJS($sc)
    {
        // Chart details
        $type            = $sc->getParameter('type',  'bar');
        $canvasName      = $sc->getParameter('name',   $this->defCanvas);
        $label           = $sc->getParameter('label',  '');
        $dataPoints      = explode(',',$sc->getParameter('datapoints',  ''));
        $dataPointsCount = count($dataPoints);
        $dataPoints      = $this->convertArrayToJSRepresentation($dataPoints);
        $dataLabels      = explode(',',$sc->getParameter('datalabels',  ''));
        $labels          = $this->convertArrayToJSRepresentation($dataLabels);

        // Data point styling
        $bkgndColors  = $this->assembleValues($sc, 'backgroundcolor', $dataPointsCount);
        $borderColors = $this->assembleValues($sc, 'bordercolor', $dataPointsCount);
        $borderWidth  = $sc->getParameter('borderwidth', 1);

        // Chart Options
        $responsive    = $sc->getParameter('responsive', 'true');
        $legend        = $sc->getParameter('legend', 'true');
        $titleDisplay  = $sc->getParameter('titledisplay', 'false');
        $titlePosition = $sc->getParameter('titleposition', 'top');

        // Build our JS from template
        $chartJSBlock = <<< chartjs
var ctx = document.getElementById("$canvasName");
var aChart = new Chart(ctx, {
    type: '$type',
    data: {
        labels: $labels,
        datasets: [{
            label: '$label',
            data: $dataPoints,
            backgroundColor: $bkgndColors,
            borderColor: $borderColors,
            borderWidth: $borderWidth
        }]
    },
    options: {
        title: {
            display: $titleDisplay,
            position: '$titlePosition',
            text: '$label'
        },
        responsive: $responsive,
        legend: $legend,
    }
});
chartjs;

        return $chartJSBlock;
    }

    /**
     * @param $canvasName
     * @param $canvasWidth
     * @param $canvasHeight
     * @param $canvasStyle
     * @return string
     */
    function buildCanvas($sc)
    {
        // Canvas details
        $canvasWidth  = $sc->getParameter('width',  $this->defWidth);
        $canvasHeight = $sc->getParameter('height', $this->defHeight);
        $canvasName   = $sc->getParameter('name',   $this->defCanvas);
        $canvasStyle  = $sc->getParameter('style', false);
        $canvasStyle  = $canvasStyle ? "style=\"$canvasStyle\"" : '';

        return "<canvas id=\"$canvasName\" width=\"$canvasWidth\" height=\"$canvasHeight\" $canvasStyle></canvas>";
    }
}
