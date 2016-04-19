
## TODO

- Config file should contain the value table for the model
- Create model for meta fields and add methods to handle getting of fields etc
- Create dynamic eloquent model for values table based on current model instance
- Tests
- Document the features and installation parts
- Deal with Relations on normal models but include a method to allow someone to append the meta fields to the attributes



```
 // Save
 $example = new Example();
 $example->name = 'Name of item'; # Default field
 $example->has_wifi = true; # Meta Field
 $example->save();

 // Find
 $example = Example::find(1);
 echo $example->name; # Name of item
 echo $example->has_wifi; # true
```

