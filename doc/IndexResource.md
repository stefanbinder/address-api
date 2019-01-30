# Index Resource Documentation
Learn how to retrieve list-data of an endpoint.
If you know jsonapi.org then you can go on and use that specification.

You want to learn more about jsonapi?
https://jsonapi.org/format/

## Sorting / Ordering

Following parameter for ordering is available:
```
sort=id
```

Default is 'id' and 'asc'
A descending ordering can be done with a leading -
```
sort=-id
``` 

Example:
```
/api/countries?sort=-code
```

## Pagination

Following two parameter for pagination are available:
```
per_page=25
page=1
```

Example:
```
/api/countries?per_page=5&page=2
```

**Attention:** the counting of page starts at 1, NOT at 0

## Filter

An index request accepts the reserved query parameter ```filter``` for filtering data.
The ```filter``` must be an array.

Simple Example for requesting all countries with the code 'us':
```
/api/countries?filter[code]=us
```

Multiple filter values can be defined comma-seperated:
```
/api/states?filter[country_id]=2,5,6
```

Multiple filter can be applied to a single request:
```
/api/states?filter[country_id]=2,5,6&filter[name]=Test
```

### Advanced Filtering
This is not in the jsonapi.org specification.

Using following possible operators in the filter (in brackets is how the code comparison is done):

- contains ( filter LIKE %value% )
- starts_with ( filter like value% )
- ends_with ( filter like %value )
- gt ( filter > value)
- gte ( filter >= value )
- lt (filter < value )
- lte (filter <= value )
- in (filter IN (value_array) )

You provide the operators in a nested array as key:

```
filter[attribute_name][operator]=value
```

Check the following examples:
```
/api/countries?filter[id][in]=23,24
/api/countries?filter[name][like]=united
/api/countries?filter[name][starts_with]=A
/api/countries?filter[created_at][gt]=2018-01-01
```

Multiple filter can be applied for one attribute:
```
/api/countries?filter[created_at][gt]=2018-01-01
/api/countries?filter[created_at][lt]=2019-01-01
```

