<script src="{{ asset('assets/admin/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea.tiny-editor',
        plugins: ['code', 'link', 'lists', 'anchor'],
        toolbar: 'code',
    });
</script>

<style>
    .tox-promotion, .tox-statusbar__branding {
        display: none !important;
    }
</style>
