Feature: User Management
    As an Organisation user
    In order to on-board other uers on the service
    I should be able to add as new person


    @user-management @ci
    Scenario Outline: Verify user in an organisation has permission to add new user
        Given I login as "<User>""
        Then I should be able to see "Manage your colleagues"

        Examples:
            | User                        |
            | par_coordinator@example.com |
            | par_business@example.com    |
            | par_authority@example.com   |

    @user-management @ci
    Scenario: Verify an enforcement officer cannot add new person
        Given I am logged in as "par_enforcement_officer@example.com"
        Then I should not see "Manage your colleagues"


    @user-management @happy path 

    Scenario Outline: Add new person
         Given I am logged in as "par_authority@example.com"
         And I click "Manage your colleagues" 
         And  I fill in add new person form
         And I click on create account
         And I select authority as "Upper West Side Borough Council"
         And I select type of user "<User-type>"
         And I click on continue invite user
         And I review the user details on review page
         When I click save
         Then I should see confirmation message "Invitation has been sent."

         Examples:
         |User-type        |
         |authority        |
         |enforcement      |


    Scenario Outline: Update user first name and phone
          Given I am logged in as "par_authority@example.com"
          And I click "Manage your colleagues" 
          When I add "AutoTest" to the inputfield "#edit-keywords"
          And I click on the button "#edit-submit-par-people"
          And I click the link text "Manage contact" 
          When I click the link text "Update Mr Autotest-firstname Autotest-lastname"
          And the element "h1.heading-xlarge" contains the text "Update contact details"
          And I add "Upated-AutoTest" to the inputfield "#edit-first-name"
          And I add "Khan" to the inputfield "#edit-last-name"
          And I click on the button "#edit-next"
          And I click on the button "#edit-next"
          And I click on the button "#edit-next"
          And I click on the button "#edit-next"
          And I click on the button "#edit-next"
          Then I should see updated details "<Element>" and "<Updated with>"
          And I should be able to save updated changes

          Examples:
          |Element|Updated with              |
          |#edit-name|Mr Upated-AutoTest Khan|
          |#edit-work-phone|07984563072      |
 
    Scenario: Verify updated changes are saved on next time page visit
          Given I am logged in as "par_authority@example.com"
          And I click "Manage your colleagues" 
          When I add "AutoTest" to the inputfield "#edit-keywords"
          And I click on the button "#edit-submit-par-people"
          And I click the link text "Manage contact" 
          When I click the link text "Update Mr Autotest-firstname Autotest-lastname"
          Then the element "#edit-first-name" contains the text "Upated-AutoTest"
          And the element "#edit-last-name" contains the text "Khan"
          And the element "#edit-work-phone" contains the text "07984563072"



    @user-management
    Scenario: Add duplicate user -existing email
        Given I login as "par_authority@example.com"
        And I click on "Manage your colleagues" link
        And I click on add new person
        And I fill-in form with existing email "par_coordinator@example.com"
        Then I should see error message user already exits
  

    @user-management @happy path

    Scenario: Verify I should be able add new user with existing user first and last name
        Given I login as "par_authority@example.com"
        And I click on "Manage your colleagues" link
        And I click on add new person
        And I fill-in form with existing user first/last name
        And I fill-in different unique email
        Then I should be able to create successfully


    @user-management
    Scenario: Update existing user
        Given
        When
        Then

    @user-management
    Scenario: Update telephone

    @user-management
    Scenario: user not able to edit with existing email

    Scenario: verify par user able to update the user roles for added user

    Scenario: Verify par user able





