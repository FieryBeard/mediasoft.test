# mediasoft.test

## Connection:

```php
$db = new QueryBuilder(); 		// with default settings
```
or
```php
$conf = array(
  	'type'      => 'mysql',			// pgsql, mssql, sqlite
	'host'      => 'localhost',
	'user'      => 'root',
	'pass'      => 'pass',
	'db'        => 'test'
	);
	
$db = new QueryBuilder($conf);	// with some of the default settings overwritten
```

## Build SQL-request

### Select:

```php
$db->select()
	->from('user')
	->where('age','>',10)
	->where('age','IS NOT NULL')
	->where('name','like','%ivan%','or')
	->in('name',array('Test',' name'))
	->not_in('age',array(16,20,17), 'OR')
	->between('age',14,50)
	->groupby(array('name','age'))
	->orderby('age')
	->limit(5)
	->offset(0,3);
```

### Insert:

```php
$db->insert('user', array('name'=>'Ivan', 'age'=>'20'));
```

### Update

```php
$db->update('user',array('name'	=> 'Ivan'))
	->where('age','>',60);
```

### Delete

```php
$db->delete('user')
	->where('age','>',50);
```

### Execute

```php
$db->save();
```
or
```php
$db->save(PDO::FETCH_NUM));
```
