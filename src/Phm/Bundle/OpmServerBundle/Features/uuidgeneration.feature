Feature: Provide Website to create a UUID which then identifies a client
  As OPM Server I provide a route to generate an uuid to enable clients to be associated with the server.

  @DropTables
  Scenario: Go to a url and create a clientId on the server which can be used to identify a client
    Given I am on "/clients/"
    When I press "create"
    Then the response status code should be 200
      And I should see "Client is created and UUID is"

  @DropTables
  Scenario: Show all registered clients
    Given I created a client with uuid "11111111-1111-1111-11111111"
    When I visit "/clients"
    Then the response status code should be 200
      And I should see "11111111-1111-1111-11111111"

  @DropTables
  Scenario: Provide delete functionality to delete a client server relation
    Given I created a client with uuid "11111111-1111-1111-11111111"
    When I visit "/clients"
      And I press "delete-11111111-1111-1111-11111111"
    Then the response status code should be 200
      And I should see "Successfully deleted client with 11111111-1111-1111-11111111 from server