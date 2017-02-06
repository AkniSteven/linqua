/**
 * Created by icefier on 31.08.16.
 */
tinymce.init({
selector:'.tiny-wysiwyg',
    height:170,
    width: 600,
    theme: 'modern',
    plugins: [
    'searchreplace wordcount visualblocks visualchars code fullscreen',

],
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: 'print preview media | forecolor backcolor emoticons',
    image_advtab: true,
    templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
],
    content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
]
});