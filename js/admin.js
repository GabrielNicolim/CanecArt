var loadFile = (event) => {
    var output = document.getElementById('preview_output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = () => {
    URL.revokeObjectURL(output.src) // free memory
    }
};