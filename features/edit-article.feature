Feature:
  I want to check an article edition

  Scenario: Edit article as non-authorized user
    Given the "Content-Type" request header is "application/json"
    Given the "Accept" request header is "application/json"
    Given the request content is:
    """
    {
      "title": "new title",
      "body": "new body"
    }
    """
    When i send "PUT" request to "/api/articles/15"
    Then http code "403" should be received

  Scenario: Edit article as authorized user with missed "title" field
    Given the "Authorization" request header is "Bearer 123"
    Given the "Content-Type" request header is "application/json"
    Given the "Accept" request header is "application/json"
    Given the request content is:
    """
    {
      "body": "new body"
    }
    """
    When i send "PUT" request to "/api/articles/15"
    Then http code "400" should be received

  Scenario: Edit article as authorized user with missed "body" field
    Given the "Authorization" request header is "Bearer 123"
    Given the "Content-Type" request header is "application/json"
    Given the "Accept" request header is "application/json"
    Given the request content is:
    """
    {
      "title": "new title"
    }
    """
    When i send "PUT" request to "/api/articles/15"
    Then http code "400" should be received

  Scenario: Edit article as authorized user with complete fields
    Given the "Authorization" request header is "Bearer 123"
    Given the "Content-Type" request header is "application/json"
    Given the "Accept" request header is "application/json"
    Given the request content is:
    """
    {
      "title": "new title",
      "body": "new body"
    }
    """
    When i send "PUT" request to "/api/articles/15"
    Then http code "200" should be received

  Scenario: Check data of edited article
    Given the "Accept" request header is "application/json"
    When i send "GET" request to "/api/articles/15"
    Then http code "200" should be received
    And the response data parameter "title" should be "new title"
    And the response data parameter "body" should be "new body"


