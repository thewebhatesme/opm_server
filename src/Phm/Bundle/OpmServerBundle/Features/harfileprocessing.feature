Feature: Provide REST Route to be able to receive a file in HAR format and store the content related to an ID
  As OPM Server I provide a route to enable clients identified by an uuid to send files in HAR format and store them
  related to this ID in the database.

  @DropTables
  Scenario: Send HAR file in a XML envelope to the server
    Given I created a client with uuid "11111111-1111-1111-11111111"
    When I send an XML envelope "clientMeasurements1.xml" to ""
    Then the response status code should be 200
      And the file "" is in the table "measurements"
      And the count result on "measurements" for client "11111111-1111-1111-11111111" should be "2"

  @DropTables
  Scenario: Send HAR file in an XML envelope to the server
    Given I created a client with uuid "11111111-1111-1111-11111111"
    When I send an XML envelope "clientMeasurements1.xml" to ""
    Then the response status code should be 200
    And the file "blocked_raw.csv" is in the table "measurements"

# This scenario loads up the file and checks if it is successful uploaded
Scenario: Login with correct credentials on english version and upload a testfile. This file is processed then
    Given I am logged in and on "/fraud-process"
    When I attach the file "src/Icans/Bundle/FraudBundle/Features/files/fraudcheck3007_raw_small.csv" to "form_file"
    And I press "form_Upload"
    Then the response status code should be 200
    And "2" messages should have been sent
    And a message should have the subject "A new list of approved users has arrived!"
    And a message should have the subject "A new file with processed user data has arrived!"
    #And the sent file should be the same as "src/Icans/Bundle/FraudBundle/Features/files/fraudcheck3007_small.csv"
    And the file "fraudcheck3007_raw_small.csv" is in the collection "FraudFile"
    And the count result on "AllreadySentUsers" should be "9198"
    And the count result on "BlockedUsers" should be "157"