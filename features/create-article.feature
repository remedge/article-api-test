Feature:
  I want to check an article creation

  Scenario: Create article as non-authorized user
    Given the "Accept" request header is "application/json"
    Given the "Content-Type" request header is "application/json"
    Given the request content is:
    """
    {
      "title": "test",
      "body": "body"
    }
    """
    When i send "POST" request to "/api/articles"
    Then http code "403" should be received

  Scenario: Create article as authorized user with missed "title" field
    Given the "Content-Type" request header is "application/json"
    Given the "Accept" request header is "application/json"
    Given the "Authorization" request header is "Bearer 123"
    Given the request content is:
    """
    {
      "body": "body"
    }
    """
    When i send "POST" request to "/api/articles"
    Then http code "400" should be received

  Scenario: Create article as authorized user with missed "body" field
    Given the "Content-Type" request header is "application/json"
    Given the "Accept" request header is "application/json"
    Given the "Authorization" request header is "Bearer 123"
    Given the request content is:
    """
    {
      "title": "title"
    }
    """
    When i send "POST" request to "/api/articles"
    Then http code "400" should be received

  Scenario: Create article as authorized user with complete fields
    Given the "Content-Type" request header is "application/json"
    Given the "Accept" request header is "application/json"
    Given the "Authorization" request header is "Bearer 123"
    Given the request content is:
    """
    {
      "title": "test",
      "body": "body"
    }
    """
    When i send "POST" request to "/api/articles"
    Then http code "200" should be received
