@csrf

@include('form.text', ['name' => 'name'])

@include('form.textarea', [
    'name' => 'body_html', 
    'label' => 'Body', 
    'is_html_editor' => true
])

