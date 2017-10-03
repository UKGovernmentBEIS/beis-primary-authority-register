@ci @journey1 @deprecated
Feature: New Direct Partnership

    Scenario: New Direct Partnership

        # SEARCH PARTNERSHIPS

        Given I am logged in as "par_admin@example.com"
        And I open the url "/admin/people"
        And I select the option with the value "par_authority" for element "#edit-role"
        And I add "55" to the inputfield "#edit-user"
        And I click on the button "#edit-submit-user-admin-people"
        And I click on the button "td.views-field.views-field-name a.username"
        And I click on the link "Edit"
        And I scroll to element "#edit-pass-pass2"
        And I add "TestPassword" to the inputfield "#edit-pass-pass1"
        # Then I expect that element ".messages" is not visible
        And I add "TestPassword" to the inputfield "#edit-pass-pass2"
        # Then I expect that element ".messages" is not visible
        When I click on the button "#edit-submit"
        Then the element ".messages" contains the text "The changes have been saved"
        And I store the user email address
        And I open the url "/user/logout"


        # PARTNERSHIPS DASHBOARD

        Given I am logged in as stored user

        # CHECK DASHBOARD CONTENTS DEPENDING ON USER LEVEL

        And I expect that element "#block-par-theme-content" contains the text "Your partnerships"
        And I expect that element "#block-par-theme-content" contains the text "Search for a partnership"
        And I expect that element "#block-par-theme-content" contains the text "See enforcement notifications"
        When I click on the link "Apply for a new partnership"

        # CHOOSE PARTNERSHIP TYPE
#        When I click on the radio ".form-radio"
#        And I click on the button "#edit-next"

        # CREATE NEW PARTNERSHIP FORM

        And I expect that element "h1" contains the text "New Partnership Application"
        When I click on the radio "#edit-application-type-direct"
        And I click on the button "#edit-next"

        # CONFIRMATIONS

        Then I expect that element "#par-partnership-application-authority-checklist" contains the text "I am authorised to submit this application"
        When I click on the button "#edit-next"
        Then I expect that element ".error-summary" is visible
        When I click on the checkbox "#edit-business-eligible-for-partnership"
        And I click on the button "#edit-next"
        Then I expect that element ".error-summary" is visible
        And I click on the checkbox "#edit-local-authority-suitable-for-nomination"
        And I click on the button "#edit-next"
        Then I expect that element ".error-summary" is visible
        And I click on the checkbox "#edit-written-summary-agreed"
        And I click on the button "#edit-next"
        Then I expect that element ".error-summary" is visible
        And I click on the checkbox "#edit-terms-organisation-agreed"
        And I click on the radio "#edit-business-regulated-by-one-authority-1"
        When I click on the button "#edit-next"
        Then I expect that element ".error-summary" is visible
        And I expect that element "#par-partnership-application-authority-checklist" contains the text "Is this your local authority?"
        And I click on the radio "#edit-business-regulated-by-one-authority-1"
        And I click on the radio "#edit-is-local-authority-1"
  #        And I expect that element ".error-summary" contains the text "The business needs to be informed about local authority"
        When I click on the button "#edit-next"
        Then I expect that element "error-summary" is not visible

        # ADD ABOUT THE PARTNERSHIP

        And I expect that element "#par-partnership-about" contains the text "Use this section to give a brief overview of the partnership"
        When I add "About the partnership detail" to the inputfield "#edit-about-partnership"
        And I click on the button "#edit-next"

        # ORGANISATION NAME

        And I add "Acme Test" to the inputfield "#edit-organisation-name"
        And I click on the button "#edit-next"

        # CONFIRM NEW PARTNERSHIP

        And I click new partnership if presented with choices
  #        And I click on the radio "#edit-par-data-organisation-id-new"
  #        And I click on the button "#edit-next"

        # ADD BUSINESS DETAIL

        When I add "SE16 4NX" to the inputfield "#edit-postcode"
        And I add "1 Change St" to the inputfield "#edit-address-line1"
        And I add "New Change" to the inputfield "#edit-address-line2"
        When I add "London" to the inputfield "#edit-town-city"
        When I add "London" to the inputfield "#edit-county"
        And I select the option with the text "England" for element "#edit-country"
        And I click on the button "#edit-next"

        # MAIN CONTACT

        When I add "Mr" to the inputfield "#edit-salutation"
        And I add "Fozzie" to the inputfield "#edit-first-name"
        And I add "Bear" to the inputfield "#edit-last-name"
        And I add "999999999" to the inputfield "#edit-work-phone"
        And I add "1111111111111" to the inputfield "#edit-mobile-phone"
        And I add "02079999999" to the inputfield "#edit-work-phone"
        And I add "078659999999" to the inputfield "#edit-mobile-phone"
        And I add "par_business_change@example.com" to the inputfield "#edit-email"
        And I click on the radio "#edit-preferred-contact-communication-mobile"
        And I add "Some additional notes" to the inputfield "#edit-notes"
        And I click on the button "#edit-next"
        And I click on the checkbox "#edit-partnership-info-agreed-authority"
        And I click on the button "#edit-save"

        # EMAIL

        Then the inputfield "#edit-email-subject" contains the text "Invitation to join the Primary Authority Registe"
        When I click on the button "#edit-next"
#    Then the element "#block-par-theme-content" contains the text "Your partnership application has been sent to"
#    Then the element "#block-par-theme-content" contains the text "par_business_change@example.com"

#        # HELPDESK USER

#        Given I am logged in as "par_helpdesk@example.com"
#        Then the element ".table-scroll-wrapper" contains the text "Acme Test"
#        When I click on the link "Approve partnership"
#        Then the element ".table-scroll-wrapper" contains the text "Are you sure you want to Approve this partnership"
#        When I press "Approve"
#        Then the element ".table-scroll-wrapper" contains the text "This partnership has been Approved"
#        When I press "Done"

#
#        Then I expect that element "#par-flow-transition-business-terms" contains the text "Please review the new Primary Authority terms and conditions and confirm that you agree with them"
#        And I click on the checkbox "#edit-terms-conditions"
#        And I click on the button "#edit-save"
#
#        # PARTNERSHIP TASKS
#
#        When I click on the link "Review and confirm your business details"
#        Then I expect that element "#edit-about-business" contains the text "About the business"
#        And I expect that element "#edit-legal-entity" contains the text "Legal Entities"
#        And I expect that element "#edit-primary-contact" contains the text "Main business contact"
#        And I expect that element "#edit-0" contains the text "Trading Names"
#
#        # EDIT REGISTERED ADDRESS
#
#        When  I click on the button "form#par-flow-transition-business-details #edit-primary-address a.flow-link"
#        And I clear the inputfield "#edit-address-line1"
#        And I clear the inputfield "#edit-address-line2"
#        And I clear the inputfield "#edit-town-city"
#        And I clear the inputfield "#edit-postcode"
#        And I clear the inputfield "#edit-county"
#        And I click on the button "#edit-save"
#        When I add "SE16 4NX" to the inputfield "#edit-postcode"
#        And I add "1 Change St" to the inputfield "#edit-address-line1"
#        And I add "New Change" to the inputfield "#edit-address-line2"
#        When I add "London" to the inputfield "#edit-town-city"
#        When I add "London" to the inputfield "#edit-county"
#        And I select the option with the text "England" for element "#edit-country"
#        When I click on the button "#edit-save"
#        Then I expect that element "span.address-line1" contains the text "1 Change St"
#        And I expect that element "span.address-line2" contains the text "New Change"
#        And I expect that element "span.locality" contains the text "London"
#        And I expect that element "span.postal-code" contains the text "SE16 4NX"
#        And I expect that element "#edit-primary-address" contains the text "England"
#
#        # EDIT MAIN BUSINESS CONTACT
#
#        When I click on the button "form#par-flow-transition-business-details #edit-primary-contact a.flow-link"
#        And I add "Harvey" to the inputfield "#edit-first-name"
#        And I add "Kneeslapper" to the inputfield "#edit-last-name"
#        And I add "999999999" to the inputfield "#edit-work-phone"
#        And I add "1111111111111" to the inputfield "#edit-mobile-phone"
#        And I add "02079999999" to the inputfield "#edit-work-phone"
#        And I add "078659999999" to the inputfield "#edit-mobile-phone"
#        And I add "par_business_change@example.com" to the inputfield "#edit-email"
#        And I click on the radio "#edit-preferred-contact-communication-mobile"
#        And I add "Some additional notes" to the inputfield "#edit-notes"
#        And I click on the button "#edit-save"
#        Then I expect that element "#edit-primary-contact" contains the text "Harvey"
#        And I expect that element "#edit-primary-contact" contains the text "Kneeslapper"
#        And I expect that element "#edit-primary-contact" contains the text "par_business_change@example.com"
#        And I expect that element "#edit-primary-contact" contains the text "2079999999"
#        And I expect that element "#edit-primary-contact" contains the text "78659999999"
#
#        # EDIT ALTERNATE CONTACT
#
#        When I click on the button "form#par-flow-transition-business-details #edit-alternative-people a.flow-link"
#        And I add "Herbert" to the inputfield "#edit-first-name"
#        And I add "Birdsfoot" to the inputfield "#edit-last-name"
#        And I add "01723999999" to the inputfield "#edit-work-phone"
#        And I add "08654999999" to the inputfield "#edit-mobile-phone"
#        And I add "par_business_change@example.com" to the inputfield "#edit-email"
#        And I click on the radio "#edit-preferred-contact-communication-mobile"
#        And I click on the button "#edit-save"
#        Then I expect that element "#edit-alternative-people" contains the text "Herbert"
#        And I expect that element "#edit-alternative-people" contains the text "Birdsfoot"
#        And I expect that element "#edit-alternative-people" contains the text "par_business_change@example.com"
#        And I expect that element "#edit-alternative-people" contains the text "01723999999"
#        And I expect that element "#edit-alternative-people" contains the text "08654999999"
#
#        # EDIT LEGAL ENTITIES
#
#        When I click on the button "form#par-flow-transition-business-details #edit-legal-entity a.flow-link"
#        And I add "Legal Entity Change" to the inputfield "#edit-registered-name"
#        And I select the option with the text "Limited Company" for element "#edit-legal-entity-type"
#        And I add "987654321" to the inputfield "#edit-company-house-no"
#        And I click on the button "#edit-save"
#        Then I expect that element "#edit-legal-entity" contains the text "Legal Entity Change"
#        And I expect that element "#edit-legal-entity" contains the text "987654321"
#        And I expect that element "#edit-legal-entity" contains the text "Limited Company"
#
#        # ADD LEGAL ENTITIES
#
#        When I click on the link "add another legal entity"
#        And I click on the button "#edit-save"
#        And I add "Another Legal Entity" to the inputfield "#edit-registered-name"
#        And I select the option with the text "Sole Trader" for element "#edit-legal-entity-type"
#        And I click on the button "#edit-save"
#
#        # PARTNERSHIP TASKS
#
#        Then I expect that element "#par-flow-transition-business-details" contains the text "Another Legal Entity"
#        And I expect that element "#par-flow-transition-business-details" contains the text "Sole Trader"
#
#        # REVIEW BUSINESS NAME AND SUMMARY
#
#        And I click on the link "edit"
#        And I add "Change to the about business details section" to the inputfield "#edit-about-business"
#        And I click on the button "#edit-save"
#        Then I expect that element "#edit-about-business" contains the text "Change to the about business details section"
#        When I click on the button "form#par-flow-transition-business-details #edit-0.js-form-item a.flow-link"
#        And I add "Trading Name Change" to the inputfield "#edit-trading-name"
#        And I click on the button "#edit-save"
#        Then I expect that element "#par-flow-transition-business-details" contains the text "Trading Name Change"
#        When I click on the link "add another trading name"
#        And I click on the button "#edit-save"
#        And I add "Trading Name Add" to the inputfield "#edit-trading-name"
#        And I click on the button "#edit-save"
#        Then I expect that element "#par-flow-transition-business-details" contains the text "Trading Name Add"
#        And I click on the checkbox "#review-partnership-summary-information-confirm"
#        And I click on the checkbox "#pa-terms-and-conditions"
#        And I click on the button "#edit-save"
#
#        # PARTNERSHIP TASKS
#
#        Then I expect that element "#block-par-theme-content" contains the text "Thankyou for completing the application"
#        And I expect that element "#block-par-theme-content" contains the text "par_authority@example.com"
#        And I click on the link "Log out"
#
#        # LOGIN SCREEN AS HELPDESK
#
#        Given I am logged in as "par_helpdesk@example.com"
#        And I open the url "/dashboard"
#
#        # APPROVE PARTNERSHIP
#
#        And the element "#partnership-status" contains the text "Apply"
#        And the element "#partnership-status" contains the text "Apply"
#        When I click on the link "Approve Prrtnership" in the page area "#partnership-action"
#        Then the element "#partnership-information" contains the text "Test Create Partnership"
#        When I click on the link "Approve"
#        Then the element "#partnership-information" contains the text "The partnership has been approved"
#        When I click on the link "Done"
#        And I open the url "/dashboard"
