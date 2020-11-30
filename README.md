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
* If you don't pass a value to the label attribute, the name passed will be used as a label.
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

#### Selectables

The selection fields are somewhat different.

These receive depending on whether they are unique or multiple, 
the `option` parameter and `options`, respectively.

A common behavior between selection fields (except select and select-multiple) 
is that, in unique fields, the label becomes the selection label, 
while in multiple-selection fields the label is the title label. For example:

* Single

```html
<x-checkbox name="is_admin" label="Is Administrator"/>

<!-- It will look like -->

<div id="field-group-is_admin" class="...">
    <input type="checkbox" id="field-is_admin" name="is_admin" value="true" class="..." >
    <label class="..." for="field-is_admin">Is Administrator</label>
</div>
```

* Multiple

```html
<x-checkbox-multiple name="languages[]" label="Programming languages" :options="$options"/>

<!-- It will look like -->

<div id="field-group-languages" class="...">
    <label>Programming languages<span class="...">Optional</span></label>
    <br>
    ...
</div>
```

* Select `<x-select/>`
* Select Multiple `<x-select-multiple/>`
* Radio `<x-radio/>`
* Radio Multiple `<x-radio-multiple/>`
* Checkbox `<x-checkbox/>`
* Checkbox Multiple `<x-checkbox-multiple/>`
* Switch `<x-switch/>`
* Switch Multiple `<x-switch-multiple/>`

As you could see, in the case above in the singular 
checkbox the option attribute was not required. However, 
this is not always the case.

##### Select `<x-select/>`

The select field receives `options` as a non-mandatory parameter, 
said parameter must be an array `['key' => 'value']`. 
However, we know that many times you want to be able to render the `options` 
to your liking, for this reason we have provided a `slot` for the options.

```html
<x-select name="brands">...your options</x-select>
```

However, using this option `slot` functionality makes you 
lose the ability to get the values from the form model, 
as well as the old values.

If you want to have a default value or empty value, you can do it using the `empty slot`.:

```html
<x-select name="brands">
    <x-slot name="empty">
        <option>Select a brand</option>
    </x-slot>
</x-select>
```

If you want to select a default option you can pass the value attribute, with the option to select.

##### Select Multiple `<x-select-multiple/>`

In the same way as the singular select, the multiple 
select has the optional parameter that is not mandatory. 
However, the difference with its singular brother is that 
the value parameter will only accept arrays with the options to be selected.

##### Radio `<x-radio/>`

This component necessarily needs the `option` attribute. 
This component changes the generation of its `label` a bit, 
since the `label` to be rendered will come out of the `option` attribute.
However you can `override` this behavior by passing the `label` to use, as with the other `components`.

##### Radio Multiple `<x-radio-multiple/>`

Like its singular sibling, the `options` parameter 
is mandatory and must be an array `['key' => 'value']`.

However, as it is a field with `multiple` options, 
the `label` of each option will come out of the provided `array`, 
and the `label` that is generated from the `name` or the one you pass will be placed as the `title`,
as explained above.

##### Checkbox `<x-checkbox/>`

This component shares similarities with `<x-radio>`. 
Only this does not necessarily need the `option` parameter, 
since its default value is `true`, this singular component 
is useful for fields such as ***"Is admin"*** or ***"Is active"***, 
in the same way the label is generated from the `name` or 
the one that has passed as a parameter is used.

##### Checkbox Multiple `<x-checkbox-multiple/>`

In the same way, the behavior of this component is similar to multiple radius.

##### Switch and Switch Multiple

These components are an inheritance of checkbox and multiple checkbox respectively. 
So its behavior is the same, but its design is not.

## Security 

If you find any security issues, please email us at admin@styde.net.
