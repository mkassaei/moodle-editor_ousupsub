@editor @editor_ousupsub @ousupsub @ousupsub_subscript @_bug_phantomjs
Feature: ousupsub subscript button
  To format text in ousupsub, I need to use the subscript button.

  @javascript
  Scenario: Subscript some text
    Given I log in as "admin"
    And I navigate to "Edit profile" node in "My profile settings"
    And I set the field "Description" to "Submarine"
    And I set the field "Text editor" to "ousupsub HTML editor"
    And I press "Update profile"
    And I follow "Edit profile"
    And I select the text in the "Description" ousupsub editor
    When I click on "Subscript" "button"
    And I press "Update profile"
    And I follow "Edit profile"
    Then I should see "<sub>Submarine</sub>" in the "Description" ousupsub editor

