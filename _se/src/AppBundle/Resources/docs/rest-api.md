# API and Authentication

## Authentication

The API allows connection via either OAuth or WSSE.

### OAuth

#### Creating a client

To connect via OAuth you first need to create an OAuth client. This can be
achieved by running the following command. After running this command you are
given the Oauth client ID and secret.

    php app/console oauth:client:create --grant-type="client_credentials"

Note: the standard application creates a client for each user bij default.

#### Requesting an access token

An Oauth client needs to pass a valid access token with each request to the
API. In order to obtain this token the client should request it through the
following URL.

    https://.../oauth/v2/token?client_id=<id>&client_secret=<secret>&grant_type=client_credentials

This call returns a JSON response containing the access token.

Note: the API documentation provides a quick link to this URL.

#### Performing an API request

As soon as you have the access token, you can add the following header to your
request in order to be authenticated.

    Authorization: bearer <access_token>

In the API documentation sandbox you can enter the access token in the "api key"
field to perform authenticated requests.

### WSSE

#### Creating an API key

Users need an API to connect via WSSE. To this end, generate a random sequence
of characters and store it with your user.

Note: the standard installation creates an API key for each newly created user.

#### Generating an authorization header

The WsseBundle provides a header service to generate a WSSE header given a user
name and an API key. It generates a nonce (random sequence of characters) and a
timestamp and creates the header.
 
Note: the API documentation generates a WSSE header for you on each refresh.

#### Performing an API request

To make an authenticated request, you need to add the generated header to your
request headers.

    X-WSSE: UsernameToken Username="...", PasswordDigest="...", Nonce="...", Created="..."

## Documentation and testing

The REST API is built on the FOSRestBundle and uses the NelmioApiDocBundle to
generate the API documentation, which also provides a nice sandbox.

    https://.../api-doc/

The documentation contains shortcuts to generate an API key or X-WSSE header.

## Security

Keep in mind that a secure implementation requires an SSL connection.
