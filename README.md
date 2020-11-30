# Styde Form

Advanced Form Generator for Laravel 7 or higher.

## Documentation

The form builder uses the Html-like syntax provided since Laravel 7 in Blade. 
So one of the components will look like `<x-input/>`, 
later we will analyze each of the components that this package includes.

### Form

The Form component is prepared so that the default http method is "get", 
however you are free to modify that method. 
Note that the form already includes csrf token when its methods are `[post, put, patch or delete]`
and the method field when its methods are `[put, patch or delete]`

Example:

* Form Get
```html
<x-form></x-form>

<!-- It will look like -->

<form method="get"></form>
```

* Form Post

```html
<x-form method="post"></x-form>

<!-- It will look like -->

<form method="post">
    <input type="hidden" name="_token" value="">
</form>
```

* Form Put, Patch o Delete

```html
<x-form method="put"></x-form>

<!-- It will look like -->

<form method="post">
    <input type="hidden" name="_token" value="">
    <input type="hidden" name="_method" value="put">
</form>
```

However, this is not all that Form can do!.

Form is prepared to receive an eloquent model, 
which will be provided to the fields within the form to be able to magically 
access the model's properties, just with the field name.

Example

* Form Model

```php
$model = new User([
    'name' => 'Luis Andrés',
    'password' => 'secret-password'
]);
```

```html
<x-form method="put" :model="$user">
    <x-input-text name="name"/>
    <x-input-password name="password"/>
</x-form>

<!-- It will look like -->

<form method="post">
    <input type="hidden" name="_token" value="">
    <input type="hidden" name="_method" value="put">

    <div id="field-group-name" class="form-group">
        <label for="field-name">Name<span class="badge badge-danger">Optional</span></label>
        <input type="text" id="field-name" name="name" value="Luis Andrés" class="form-control">
    </div>

    <div id="field-group-password" class="form-group">
        <label for="field-password">Password<span class="badge badge-danger">Optional</span></label>
        <input type="password" id="field-password" name="password" value="" class="form-control">
    </div>
</form>
```

Surely by now, you already have many questions, 
such as ***why is there an Optional badge?*** or 
***why is the name shown but not the password?***

Quiet we will get to explain everything that involves the fields,
 but to give a short answer, 
 the Optional badge is configurable from the `config` file, 
 even each of the views are modifiable, you just have to publish them.

Note that if any property is set to `hidden` in your model, 
it will not be shown, that's why the password is not shown.

### Fields

We have separated the fields into two groups, the input and the selectable ones.
However, all these fields share many similarities and very epic functionalities.

For example,

* All must have a mandatory name.
* Everyone can get the value(s) of the model passed to the form
* If the field in question has an error (Laravel validations), 
the value will be taken from the old helper that brings the last value entered.
* You can pass html attributes to it as if it were a normal field, example:

```html
<x-input-text name="test" class="mt-5" maxlength="10" value="Luis"/>
```

```html
<x-select name="test-select" class="mt-5" required/>
```

* You can pass a help text to it by adding the help attribute to the field, example: 

```html
<x-input-text name="test" help="This is a help text."/>
```

```html
<x-select name="test-select" help="This is a help text."/>
```

* If a field has an error (Laravel validations), 
this field will automatically show a feedback of the error and the css 
styles will be applied to that field.

#### Inputs

If you remember above we mentioned `<x-input/>`, 
however we recommend the use of dedicated inputs for example `<x-input-text/>`, 
however the use of `<x-input/>` is for types like (`color`, `date`, `month`, and similars). 
Next we will see each of the types of inputs that this package provides

* Input Text `<x-input-text/>`
* Input Number `<x-input-number/>`
* Input Password `<x-input-password/>`
* Input Email `<x-input-email/>`
* Input Url `<x-input-url/>`
* Input Search `<x-input-search/>`
* Input File `<x-input-file/>`
* Input Range `<x-input-range/>`
* Textarea `<x-textarea/>`
* Input `<x-input/>`



## Security 

If you find any security issues, please email us at admin@styde.net.
