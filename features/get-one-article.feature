Feature:
  I want to check one article receiving

  Scenario: Get one existing article
    Given the "Accept" request header is "application/json"
    When i send "GET" request to "/api/articles/51"
    Then http code "200" should be received

  Scenario: Get one non-existing article
    Given the "Accept" request header is "application/json"
    When i send "GET" request to "/api/articles/151"
    Then http code "404" should be received

  Scenario: Get one existing article with non accept-header 'xml'
    Given the "Accept" request header is "application/xml"
    When i send "GET" request to "/api/articles/51"
    Then http code "406" should be received


