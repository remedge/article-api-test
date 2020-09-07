Feature:
  I want to check articles list receiving

  Scenario: Get list without params
    Given the "Accept" request header is "application/json"
    When i send "GET" request to "/api/articles"
    Then http code "200" should be received

  Scenario: Get list with all params
    Given the "Accept" request header is "application/json"
    When i send "GET" request to "/api/articles?page=2&sortByField=title&sortOrder=asc"
    Then http code "200" should be received

  Scenario: Get list with non accept-header 'xml'
    Given the "Accept" request header is "application/xml"
    When i send "GET" request to "/api/articles?page=2&sortByField=title&sortOrder=asc"
    Then http code "406" should be received

  Scenario: Get list with incorrect params
    Given the "Accept" request header is "application/json"
    When i send "GET" request to "/api/articles?page=2&sortByField=title&sortOrder=ascxx"
    Then http code "400" should be received

