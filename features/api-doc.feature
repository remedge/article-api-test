Feature:
  I want to check a api-doc URL

  Scenario: It receives a response api-doc URL
    When i send "GET" request to "/api/doc"
    Then http code "200" should be received
