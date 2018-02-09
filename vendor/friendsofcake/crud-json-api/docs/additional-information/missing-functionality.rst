Missing Functionality
=====================

Even though this listener is used in real applications, some parts of the JSON API
specification have not yet been implemented. Feel free to submit a PR for the missing
functionality listed below and help work towards a full-featured implementation
of the specification, the effort should be minimal.

JSON API Links
^^^^^^^^^^^^^^

The JsonApiListener is currently missing
`JSON API Links <http://jsonapi.org/format/#document-links?>`_
functionality.

JSON API Sorting
^^^^^^^^^^^^^^^^

The JsonApiListener currently does not fully support
`JSON API Sorting <http://jsonapi.org/format/#fetching-sorting>`_
.

* - single field sorting works
* - (optional) multi field sorting does not yet work

JSON API Sparse Fieldsets
^^^^^^^^^^^^^^^^^^^^^^^^^

The JsonApiListener is currently missing support for
`JSON API Sparse Fieldsets <http://jsonapi.org/format/#fetching-sparse-fieldsets>`_
.

JSON API Filtering
^^^^^^^^^^^^^^^^^^

The JsonApiListener currently does not fully support
`JSON API Filtering <http://jsonapi.org/format/#fetching-filtering>`_
.
