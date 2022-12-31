import CkEditorCustomSimpleAdapter from './ckeditor-adapter'

function CkEditorUploadAdapterFunction(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new CkEditorCustomSimpleAdapter(loader);
    };
}

BalloonBlockEditor
    .create( document.querySelector( '#content' ), {
        extraPlugins: [CkEditorUploadAdapterFunction],
        placeholder: 'Type the content here!'
    } )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( error => {
        console.error( 'Oops, something went wrong!' );
        console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
        // console.warn( 'Build id: ymmqk5ppasd3-cvuc8iz70blj' );
        console.error( error );
    } );

