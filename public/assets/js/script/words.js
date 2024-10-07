document.addEventListener('DOMContentLoaded', function() {
    if (typeof words !== 'undefined' && words.length > 0) {
        var currentIndex = 0;
        var typedElement = document.getElementById('typed-output');

        function typeWord(word) {
            var index = 0;
            typedElement.innerHTML = '';
            typedElement.classList.add('typing');
            
            function addLetter() {
                if (index < word.length) {
                    if (word[index] === '|') {
                        typedElement.innerHTML += '<br>';
                    } else {
                        typedElement.innerHTML += word[index];
                    }
                    index++;
                    setTimeout(addLetter, 100);
                } else {
                    typedElement.classList.remove('typing');
                    setTimeout(eraseWord, 2000);
                }
            }
            
            addLetter();
        }

        function eraseWord() {
            var lines = typedElement.innerHTML.split('<br>');
            typedElement.classList.add('typing');
            
            function removeLine() {
                if (lines.length > 0) {
                    lines.pop();
                    typedElement.innerHTML = lines.join('<br>');
                    setTimeout(removeLine, 500);
                } else {
                    typedElement.classList.remove('typing');
                    currentIndex = (currentIndex + 1) % words.length;
                    setTimeout(function() { typeWord(words[currentIndex]); }, 500);
                }
            }
            
            removeLine();
        }

        typeWord(words[currentIndex]);
    } else {
        console.error('Words array is not defined or empty');
    }
});
