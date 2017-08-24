# Shortcode Charts Js Plugin

The **Shortcode Chart.js** Plugin is for [Grav CMS](http://github.com/getgrav/grav). It is a shortcode extension that add support for Chart.js to your Grav website.

## Installation

Installing the Shortcode Chart.js plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install shortcode-chartjs

This will install the Shortcode Charts Js plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/shortcode-chartjs`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `shortcode-chartsjs`. You can find these files on [GitHub](https://github.com/craig-phillips/grav-plugin-shortcode-chartjs) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/shortcode-chartsjs
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/shortcode-charts-js/shortcode-chartjs.yaml` to `user/config/plugins/shortcode-chartjs.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

## Usage

**Describe how to use the plugin.**

## Credits

This Grav Shortcode Plugin is only possible because of the awesome work of the [Chart.js](http://www.chartjs.org) project and it's [contributors](https://github.com/chartjs/Chart.js/contributors).

## To Do

- [ ] Future plans, if any

