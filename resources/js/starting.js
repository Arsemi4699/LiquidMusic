const listenNumberCounter = document.getElementById("number__listen");
const artistNumberCounter = document.getElementById("number__artist");
const musicNumberCounter = document.getElementById("number__music");

NumberCounter(listenNumberCounter);
NumberCounter(artistNumberCounter);
NumberCounter(musicNumberCounter);

function NumberCounter(targetEl) {
    let targetNum = targetEl.dataset.value;
    let startNum = 0;
    let scope = 1;
    if (targetNum < 50 && targetNum > 10) {
        scope = 5;
    }
    while (scope * 50 < targetNum) {
        scope *= 10;
    }
    let counterTimer = setInterval(() => {
        if (startNum + scope <= targetNum) {
            startNum += scope;
            targetEl.innerHTML = startNum + "+";
        } else {
            clearInterval(counterTimer);
        }
    }, 100);
}
