Fetching Data
=============

HTTP GET (index)
^^^^^^^^^^^^^^^^

Requests to the ``index`` action **must** use:

- the ``HTTP GET`` request type
- an ``Accept`` header  set to ``application/vnd.api+json``

A successful request will respond with HTTP response code ``200``
and response body similar to this output produced by
``http://example.com/countries``:

.. code-block:: json

  {
    "data": [
      {
        "type": "countries",
        "id": "1",
        "attributes": {
          "code": "NL",
          "name": "The Netherlands"
        },
        "links": {
          "self": "/countries/1"
        }
      },
      {
        "type": "countries",
        "id": "2",
        "attributes": {
          "code": "BE",
          "name": "Belgium"
        },
        "links": {
          "self": "/countries/2"
        }
      }
    ]
  }

HTTP GET (view)
^^^^^^^^^^^^^^^

Requests to the ``view`` action **must** use:

- the ``HTTP GET`` request type
- an ``Accept`` header  set to ``application/vnd.api+json``

A successful request will respond with HTTP response code ``200``
and response body similar to this output produced by
````http://example.com/countries/1``:

.. code-block:: json

  {
    "data": {
      "type": "countries",
      "id": "1",
      "attributes": {
        "code": "NL",
        "name": "The Netherlands"
      },
      "links": {
        "self": "/countries/1"
      }
    }
  }

Associated data
^^^^^^^^^^^^^^^

The listener will detect associated data as produced by
``contain`` and will automatically render those associations
into the JSON API response as specified by the specification.

Let's take the following example code for the ``view`` action of
a Country model with a ``belongsTo`` association to Currencies
and a ``hasMany`` relationship with Cultures:

.. code-block:: php

  public function view()
  {
    $this->Crud->on('beforeFind', function (Event $event) {
      $event->getSubject()->query->contain([
        'Currencies',
        'Cultures',
      ]);
    });

    return $this->Crud->execute();
  }

Assuming a successful find the listener would produce the
following JSON API response including all associated data:

.. code-block:: json

  {
    "data": {
      "type": "countries",
      "id": "2",
      "attributes": {
        "code": "BE",
        "name": "Belgium"
      },
      "relationships": {
        "currency": {
          "data": {
            "type": "currencies",
            "id": "1"
          },
          "links": {
            "self": "/currencies/1"
          }
        },
        "cultures": {
          "data": [
            {
              "type": "cultures",
              "id": "2"
            },
            {
              "type": "cultures",
              "id": "3"
            }
          ],
          "links": {
            "self": "/cultures?country_id=2"
          }
        }
      },
      "links": {
        "self": "/countries/2"
      }
    },
    "included": [
      {
        "type": "currencies",
        "id": "1",
        "attributes": {
          "code": "EUR",
          "name": "Euro"
        },
        "links": {
          "self": "/currencies/1"
        }
      },
      {
        "type": "cultures",
        "id": "2",
        "attributes": {
          "code": "nl-BE",
          "name": "Dutch (Belgium)"
        },
        "links": {
          "self": "/cultures/2"
        }
      },
      {
        "type": "cultures",
        "id": "3",
        "attributes": {
          "code": "fr-BE",
          "name": "French (Belgium)"
        },
        "links": {
          "self": "/cultures/3"
        }
      }
    ]
  }

Include Parameter
^^^^^^^^^^^^^^^^^

The listener also supports the ``include`` parameter to allow clients to
customize related resources. Using that same example as above, the client
might request ``/countries/2?include=cultures,currencies`` to achieve the
same response. If the include parameter is provided, then only requested
relationships will be included in the ``included`` schema.

It is possible to blacklist, or whitelist what the client is allowed to include.
This is done using the listener configuration:

.. code-block:: php

  public function view()
  {
    $this->Crud
      ->listener('jsonApi')
      ->config('queryParameters.include.whitelist', ['cultures', 'cities']);

    return $this->Crud->execute();
  }

Whitelisting will prevent all non-whitelisted associations from being
contained. Blacklisting will prevent any blacklisted associations from
being included. Blacklisting takes precedence of whitelisting (i.e
blacklisting and whitelisting the same association will prevent it from
being included). If you wish to prevent any associations, set the ``blacklist``
config option to ``true``:

.. code-block:: php

  public function view()
  {
    $this->Crud
      ->listener('jsonApi')
      ->config('queryParameters.include.blacklist', true);

    return $this->Crud->execute();
  }

.. note::

Please note that only support for ``belongsTo`` and ``hasMany``
relationships has been implemented.
