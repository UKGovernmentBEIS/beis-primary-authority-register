# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [41.0.0] - TBD
### Fixed
- Incorrect formatting applied to some partnership descriptions.

## [40.0.0] - 2020-07-06
### Fixed
- Security update.
- Corrected missing pagination for members of coordinated partnerships.
### Updated
- Improved ability to combine duplicate contact records.
- Updated partnership search pages with correct information about coordinated partnerships.
- Improved display of listings with no results.

## [39.0.5] - 2020-06-15
### Fixed
- Resolved errors with partnerships that did not have any address registered.

## [39.0.4] - 2020-06-04
### Fixed
- Prevented double click submission of forms.

## [39.0.2] - 2020-06-02
### Fixed
- Prepared code for major software update (Drupal 9).
- Support team can remove legal entities from a partnership before nomination.
### Updated
- Improved the display of partnership pages, particularly where inconsistent information appeared to different users.

## [38.0.0] - 2020-04-21
### Fixed
- Resolved some issues with the partnership reports for the support team.
- Resolved issues with the password reset functionality.
- Removed the ability to refer enforcement notices to revoked partnerships.
- Resolved the ability to enforce members of a coordinated partnership.
- Resolved performance issues with the partnership pages.

## [37.0.4] - 2020-02-04
### Updated
- Duplicate legal entities will now be merged together.
- Inspection plans now revoked when they pass their expiration date.
- Archived advice will now appear at the bottom of listings.
- Approval process for partnerships improved to suggest the appropriate regulatory functions.
### Added
- Notifications for when inspection plans expire.
- Notifications for when new inspection plans are added.

## [36.0.0] - 2019-12-17
### Updated
- Partnership page restructured to make important information clearer.
- Partnerships can now be searched by the text in the about partnership section.

## [35.0.0] - 2019-11-11
### Added
- Ability to upload new inspection plans.
- Inspection plans can have a title and summary to identify them more clearly.
- Ability to revoke inspection plans.

## [34.1.0] - 2019-10-10
### Updated
- All user names replaced with e-mail addresses.

## [34.0.4] - 2019-10-07
### Updated
- Filtering of advice on a partnership improved.
### Added
- Support team can remove user accounts and block users.

## [33.0.1] - 2019-09-05
### Added
- Ability to cancel partnership applications.
- Support team can view all authorities and organisations.
- Support team can add new authorities and organisations.
- Support team can update authorities and organisations.

## [32.0.0] - 2019-08-05
### Updated
- Highlight the impact of changing the contact details for a person.
- Improved adding a contact to a partnership, including de-duplication of similar contacts.
### Added
- Contacts can now be removed from a partnership.

## [31.1.0] - 2019-07-11
### Updated
- Access to advice locked down.

## [31.0.0] - 2019-07-04
### Updated
- Partnership search can find documents by advice titles.
### Added
- A summary can be added to advice.
- Advice on a partnership can be filtered.
- Advice can be archived.

## [30.1.0] - 2019-06-17
### Updated
- Access to partnerships locked down.

## [30.0.0] - 2019-05-13
### Updated
- Security upgrade for core software.

## [29.0.1] - 2019-05-07
### Fixed
- Improved performance issues all users.

## [28.1.0] - 2019-05-01
### Fixed
- Improved performance issues for authorities and organisations with lots of users.
### Updated
- Upgraded core software.

## [28.1.0] - 2019-04-10
### Fixed
- Resolved issues with members being incorrectly expired when uploading membership CSV files.
- Improved error messages when uploading membership CSV files.
- Resolved issue showing incorrect enforcement officer on referred enforcement notices.
### Added
- Better selection mechanism to allow members of the Processing Team to more easily create users and enforcement notices.
- Better caching to increase performance to all users.

## [28.0.0] - 2019-04-03
### Added
- Users can now add and update members in their organisations or authorities.
- Users can now re-issue invites to users that may not have received them.
- Users can change roles and remove members from their organisations or authorities.

## [27.1.0] - 2019-03-13
### Updated
- Fixes to resolve issues with the CSV export for admin users.

## [27.0.3] - 2019-03-04
### Updated
- Critical security fixes
- Resolved issues when clicking notification links.
- Stopped users from updating legal entities for active partnerships.

## [27.0.0] - 2018-11-26
### Added
- Information about who approved an enforcement notice.
- Notice to tell users to add the coordinator's legal entities when creating a coordinated partnership not those belonging to the members.
- A page to the start of a new enforcement to make sure the enforcing officer has been in contact with the primary authority prior to raising the notice.

### Fixed
- Only able to select the first 10 members when enforcing a coordinated partnership.

## [26.0.1] - 2018-11-05
### Changed
- Updated notification links to go to the related content rather than the dashboard.
- Allowed notifications to go to email address that don't have user accounts.
- Allowed users to login first when clicking links from emails.
- Added notification preferences options to allow contacts who aren't the primary contact to receive notifications.

## [25.0.0] - 2018-10-17
### Changed
- Improved partnership application process, reducing the number of conditions checkboxes and overall worrdiness.
- Improved member upload forms, adding a blank template to start from.

## [24.1.0] - 2018-10-07
### Added
- Enabled postcode lookup functionality.
- New help desk dashboard.
- New more granular permissions for each task improve control over which users can perform which actions.

### Changed
- Corrected links in email notification for responses to general enquiries.

## [24.0.1] - 2018-10-04
### Added
- Postcode lookup functionality (not yet turned on).

### Changed
- Helpdesk partnership list can now be searched by legal entity name.

### Fixed
- It is no longer possible for helpdesk users to assign themselves super administrator rights.
- Resolved an issue that was stopping the auto-approval of deviation requests.

## [23.2.0] - 2018-09-18
### Added
- Notifcations for new enquiries.
- Notifications for responses to enquiries.
- Auto-approval of deviation requests after 5 working days.

### Fixed
- Resolved issues with attachments not showing for Enforcement actions.
- Resolved problem whereby validation for legal entities could be skipped under certain circumstances.

## [23.1.2] - 2018-09-11
### Changed
- Security update to core software.
- Inspection plan feedback and deviation requests cannot be created without an inspection plan.
### Fixed
- Resolved caching issue with user's enquiry lists.
- Resolved issue of multiple notifications sent to the primary authority when a new enforcement notice is created.
### Removed
- Removed duplicate enforcement notices with no actions attached.

## [23.0.0] - 2018-09-03
### Added
- Request to deviate from inspection plan process.
- Feedback on inspection plans process.
- General enquiries to a PA.

## [22.0.0] - 2018-08-27
### Changed
- Enforced statuses so that they can only trainsition between allowed statuses.
- Added extra checks to make sure only the PA can review enforcement notices.
- Filled in missing nation data for partnerships.
- Added the date the partnership was last updated.
- Accessibility improvements.

## [21.0.0] - 2018-08-14
### Added
- Added further validation to elements that were missing it.

### Changed
- Updated error messages to link to the element that caused the error.
- Improved validation messages to be clearer and more understandable.
- Feedback form URL.

## [20.2.1] - 2018-07-26
### Added
- Role assignment so that the administrator role can only be assigned by administrators.

### Fixed
- Removed sporadic issue downloading the Help Desk CSV report.

## [20.1.0] - 2018-07-16
### Changed
- Updated the public primary authority search with partnership type column and better search.
- Public register now has more search options and displays a 'no results' message if no partnerships were found.
- Partnership type has been added to all partnership search lists.

### Fixed
- Added the correct completion text at the end of the partnership confirmation process.
- Accessibility issues showing complex labels to screenreaders
- Forms where multiples can now be added show '(optional)' help text for all but the first item.
- Hidden menu links disabled for screenreader.
- Pagination now validates as (x)html.

## [20.0.1] - 2018-07-05
### Added
- GDPR agreement required after registration.
- Profile update capabilities allows review of user's.
- A password policy for all users that requires new passwords to be a minimum of 8 characters long, not contain all lowercase or all uppercase characters, and not use commonly used words or sequences of characters.

### Changed
- Performance improvements made by removing relationships to deleted data.

## [19.0.0] - 2018-06-25
### Added
- Added journeys for helpdesk users to restore mistakenly revoked partnerships.
### Changed
- Updated display of enforcement actions to always include attachments.
### Fixed
- Partnerships now show up immediately in a users dashboard when first created.
- Resolved missing relationships between users and their relevant enforcements and partnerships.

## [18.3.2] - 2018-06-10
### Fixed
- Resolved issues blocking enforcements that can be referred.

## [18.3.1] - 2018-06-07
### Added
- Authorities can now complete business details.
- New links on partnership review screen to allow details to be changed.
### Fixed
- Allow legal entiites to be changed from the review page under rare use cases when none are present.
- Partnerships can no longer be transitioned back to 'Confirmed by the organisation' once they have been nominated.
- Notifications of enforcement review are now being sent to the correct enforcement officer.
- Resolved issues blocking the creation of new partnerships.

## [18.2.0] - 2018-06-06
### Added
- Login now works both in lower and upper case.
- Added missing pages for advice and inspeciton plans when searching for a partnership.
### Changed
- User account link now goes to the dashboard.
### Fixed
- Corrected issues adding multiple enforcement actions.
- Improved general accessibility issues.

## [18.1.0] - 2018-06-02
### Changed
- Improved dashboard for users that have been removed from authorities or organisations.
### Fixed
- Corrected default value for 'Covered by Inspection' radio options.
- List formatting removed from email messages.
- Resolved issues with a recent upgrade to invitations.
### Removed
- Filtered deleted items from the helpdesk partnership list.

## [18.0.0] - 2018-05-30
### Added
- New CSV report page for the helpdesk.
### Changed
- Updated instructional text to help users upload attachements.
- Enforcement journeys given UI improvements and multiple fixes to allow more partnerships to be enforced, improve notifications and reduce errors.
### Fixed
- Removed duplicate email signature from some email notifications.
- Resolved failure of invite emails to new users during partnership creation.

## [1.0.0] - 2017-08-22
### Added
- Transition site released
