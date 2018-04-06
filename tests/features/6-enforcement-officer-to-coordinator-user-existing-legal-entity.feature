@ci
Feature: Enforcement Officer/Coordinator - Enforcement Notice Process

    Scenario Outline: Enforcement Officer/Coordinator - Issue enforcement notice

        #LOGIN
        
        Given I am logged in as "par_enforcement_officer@example.com"

        # CREATE ENFORCEMENT NOTIFICATION

        And I create new valid enforcement notication "<Notification Title>" for organisation "<Organisation>"

        # CHECK ENFORCEMENT NOTIFICATION

        Then I check that EO can see valid enforcement notification "<Notification Title>"

        Examples:
            | Notification Title        | Organisation      |
            # | Enforcement notifce 1  | Charlie's Cafe    |
            # | Enforcement notifce 2  | Charlie's Cafe    |
            | Enforcement notice 3  | Charlie's Cafe    |
            # | Enforcement notifce 4  | Charlie's Cafe    |