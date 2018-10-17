var value = document.getElementById('test').value;

function trackChanges(oldVal) {
    var newVal = document.getElementById('test').value;

    if (newVal !== oldVal) {
        alert('Changes occured!');
    }

    var fn = function () { trackChanges(newVal); };

    setTimeout(fn(),100);
}

setTimeout(trackChanges(value), 100);