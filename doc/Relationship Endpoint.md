# Relationship Endpoint possible routings
According to JSON-API every resource should have the relationships route.
With the endpoints you can attach/detach relations from the main resource.

## Index 
Get all available resources, get back list of identifier objects.
```
GET /countries/1/relationships/states
```

The response will look like:

```json
{
    "links": {
        "self": "/api/countries/1/relationships/states",
        "related": "/api/countries/1/states"
    },
    "data": [
        {
            "id": 1,
            "type": "states"
        },
    ]
}
```

## Store
Attach an existing object to the main resource. You can either send a single object or a list (in case the relation is a toMany relationship)
```
POST /countries/1/relationships/states
{ 
    data: {
        id: 1, 
        type: 'states' 
    } 
}
```

```
POST /countries/1/relationships/states
{ 
    data: [
        { id: 1, type: 'states' },
        { id: 2, type: 'states' },
        { id: 3, type: 'states' }, 
    ]
}
```

As response you will receive the list of attached objects.

If you POST to a toOne relationship, then the existing one will be replaced.
For example: 
1. country has one president
2. POST new president
3. sent president is replacing current one

## Update
Is mainly the same as Store, but arrays are treated different. If an array of identifier objects are sent, 
it will synchronize the stored list 

1. elements will be removed if they don't exist in given list (Request)
2. elements will be added if they don't exist in existing list (DB) 

## Destroy
It will delete the relationship.
If the relation is toOne, no request-body is needed.
If the relation is toMany, send a list of identifier objects which shall be deleted.
