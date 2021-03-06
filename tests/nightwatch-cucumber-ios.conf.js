const seleniumServer = require('selenium-server')
const chromedriver = require('chromedriver')

require('nightwatch-cucumber')({
    cucumberArgs: [
            '--require', 'step-definitions-v1',
            '--require', 'support',
            '-- --tag', 'ci',
            '--format', 'node_modules/cucumber-pretty',
            '--format', 'json:reports/cucumber.json',
            'features-v1'
        ]
})

module.exports = {
    output_folder: 'reports',
    custom_assertions_path: 'step-definitions-v1/assertions',
    page_objects_path: 'step-definitions-v1/page_objects',
    globals_path : 'step-definitions-v1/globals/globalModules.js',
    live_output: false,
    disable_colors: false,
    selenium: {
        start_process: false,
        server_path: seleniumServer.path,
        log_path: '',
        host: '127.0.0.1',
        port: 4444
    },
    appium: {
        start_process: false
    },
    test_settings: {
        default: {
            launch_url: 'http://localhost:8111',
            selenium_port: 4723,
            selenium_host: '127.0.0.1',
            silent: true,
            desiredCapabilities : {
                automationName: 'XCUITest',
                browserName : 'Safari',
                platformName : 'iOS',
                platformVersion : '11.2',
                deviceName : 'iPad Air 2',
                // noReset: false
              // "app": APP_PATH + "ios/PieDrive.app", // path for the ios app you want to test
            },
            screenshots : {
                enabled : true,
                on_failure : true,
                path: './reports/screenshots'
            },
            selenium: {
                cli_args: {
                    'webdriver.chrome.driver': chromedriver.path
                }
            }
        },
    }
}
