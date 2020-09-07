Feature:
  I want to check an article deletion

  Scenario: Delete article as non-authorized user
    When i send "DELETE" request to "/api/articles/20"
    Then http code "403" should be received

  Scenario: Delete non-existing article article as authorized user
    Given the "Accept" request header is "application/json"
    Given the "Authorization" request header is "Bearer 123"
    When i send "DELETE" request to "/api/articles/120"
    Then http code "500" should be received

  Scenario: Delete existing article article as authorized user
    Given the "Accept" request header is "application/json"
    Given the "Authorization" request header is "Bearer 123"
    When i send "DELETE" request to "/api/articles/20"
    Then http code "200" should be received

  Scenario: Delete the same article article as authorized user
    Given the "Accept" request header is "application/json"
    Given the "Authorization" request header is "Bearer 123"
    When i send "DELETE" request to "/api/articles/20"
    Then http code "500" should be received

  Scenario: Check data of deleted article
    Given the "Accept" request header is "application/json"
    When i send "GET" request to "/api/articles/20"
    Then http code "404" should be received

