Feature: New Direct Partnership For PA To Approve

    @profileupdate @ci
    Scenario: Update profile with one contact record

        Given I am logged in as "par_authority_profile@example.com"

        Then the element "h1.heading-xlarge" contains the text "Primary Authority Register"
        And I click the link text "Manage your profile details"

        Then the element "h1.heading-xlarge" contains the text "Confirm acceptance of data policy"
        And the element "#content" contains the text "I have read the Privacy Notice and understand how the Office intend to use my personal data"
        When I click on the button "#edit-next"

        # GDPR has now been confirmed, check that this screen does
        # not show if we choose to manage profile again.
        And I click on the button "#edit-cancel"
        And I click the link text "Manage your profile details"

        Then the element "h1.heading-xlarge" contains the text "Update contact details"
        When I add "Dr" to the inputfield "#edit-salutation"
        And I add "Bloggs" to the inputfield "#edit-last-name"
        And I add "01865999000" to the inputfield "#edit-work-phone"
        And I click on the button "#edit-next"

        Then the element "h1.heading-xlarge" contains the text "Update communication preferences"
        When I click on the checkbox "#edit-preferred-contact-communication-phone"
        And I add "Please only contact me during office hours." to the inputfield "#edit-notes"
        And I click on the button "#edit-next"

        Then the element "h1.heading-xlarge" contains the text "Profile review"
        And the element "#edit-name" contains the text "Dr Harry Bloggs"
        And the element "#edit-work-phone" contains the text "01865999000 (preferred)"
        And the element "#edit-mobile-phone" contains the text "0777777777"
        And the element "#edit-communication-noes" contains the text "Please only contact me during office hours."
        And I click on the button "#edit-save"

        Then the element "h1.heading-xlarge" contains the text "Thank you for updating your profile"
        And I click the link text "Done"

        # Check the values have been properly saved.
        Then the element "h1.heading-xlarge" contains the text "Primary Authority Register"
        And I click the link text "Manage your profile details"

        Then the element "h1.heading-xlarge" contains the text "Update contact details"
        And the inputfield "#edit-salutation" contains the text "Dr"
        And the inputfield "#edit-first-name" contains the text "Harry"
        And the inputfield "#edit-last-name" contains the text "Bloggs"
        And the inputfield "#edit-work-phone" contains the text "01865999000"

    @profileupdate @ci
    Scenario: Update and merge profile with multiple contact records

        Given I am logged in as "par_authority_multiple_contacts_profile@example.com"

        Then the element "h1.heading-xlarge" contains the text "Primary Authority Register"
        And I click the link text "Manage your profile details"

        Then the element "h1.heading-xlarge" contains the text "Confirm acceptance of data policy"
        And the element "#content" contains the text "I have read the Privacy Notice and understand how the Office intend to use my personal data"
        When I click on the button "#edit-next"

        Then the element "h1.heading-xlarge" contains the text "Choose which contact to update"
        Then I click on the radio "Mrs  Smith"
        When I click on the button "#edit-next"

        Then the element "h1.heading-xlarge" contains the text "Update contact details"
        And I click on the button "#edit-next"
        When the element ".error-summary" does exist
        Then I add "Joe" to the inputfield "#edit-first-name"
        And I add "01870119991" to the inputfield "#edit-work-phone"
        And I click on the button "#edit-next"

        Then the element "h1.heading-xlarge" contains the text "Update communication preferences"
        When I click on the checkbox "#edit-preferred-contact-communication-phone"
        And I click on the button "#edit-next"

        Then the element "h1.heading-xlarge" contains the text "Profile review"
        And the element "#edit-name" contains the text "Mrs Joe Smith"
        And the element "#edit-work-phone" contains the text "01870119991 (preferred)"
        And the element "#edit-mobile-phone" contains the text "0777777777"
        And the element "#edit-communication-noes" contains the text "(none)"
        And I click on the button "#edit-save"

        Then the element "h1.heading-xlarge" contains the text "Thank you for updating your profile"
        And I click the link text "Done"

        # Once the profile is saved and merged the contact
        # selection screen shouldn't be shown again.
        Then the element "h1.heading-xlarge" contains the text "Primary Authority Register"
        And I click the link text "Manage your profile details"

        Then the element "h1.heading-xlarge" contains the text "Update contact details"
        And the inputfield "#edit-salutation" contains the text "Mrs"
        And the inputfield "#edit-first-name" contains the text "Joe"
        And the inputfield "#edit-last-name" contains the text "Smith"
        And the inputfield "#edit-work-phone" contains the text "01870119991"
