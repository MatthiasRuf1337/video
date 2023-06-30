let mediaRecorder;
let recordedBlobs = [];
let stream;
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');


document.querySelector('#start').addEventListener('click', () => {
  const constraints = {
    audio: true,
    video: true

  };

  navigator.mediaDevices.getUserMedia(constraints)
    .then(localMediaStream => {
      // Diese Zeile macht .box2 sichtbar, wenn der Startknopf geklickt wird
      document.querySelector('.box2').style.display = 'block';
document.querySelector('body').scrollIntoView({ behavior: 'smooth', block: 'end' });


      stream = localMediaStream;
      document.querySelector('#preview').srcObject = stream;
      mediaRecorder = new MediaRecorder(stream);

      mediaRecorder.onstop = (event) => {
            document.querySelector('#upload-message').style.display = 'flex';
        const blob = new Blob(recordedBlobs, {type: 'video/webm'});
        const fileName = generateUniqueFileName(); // Generierung eines eindeutigen Dateinamens
        const formData = new FormData();
        formData.append('video', blob, fileName);
        formData.append('id', id);

        const progressElement = document.getElementById('upload-progress');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload_video.php', true);
        xhr.upload.addEventListener('progress', (event) => {
          if (event.lengthComputable) {
            const percentComplete = (event.loaded / event.total) * 100;
            console.log(`Upload Fortschritt: ${percentComplete}%`);
            progressElement.textContent = `Upload Fortschritt: ${percentComplete}%`;
          }
        });

       xhr.onreadystatechange = function() {
  if (xhr.readyState === 4) {
    if (xhr.status === 200) {
                document.querySelector('#upload-message').style.display = 'none';
      console.log('Video wurde erfolgreich hochgeladen!');
      progressElement.textContent = 'Video wurde erfolgreich hochgeladen!';
      window.location.href = '/danke.html';  // Ändern Sie dies in die URL, zu der Sie weiterleiten möchten.
    } else {
      console.error('Fehler beim Hochladen des Videos.');
      progressElement.textContent = 'Fehler beim Hochladen des Videos.';
    }
  }
};

        xhr.send(formData);
      };

      mediaRecorder.ondataavailable = (event) => {
        if (event.data && event.data.size > 0) {
          recordedBlobs.push(event.data);
        }
      };

      let countdownInterval;
      let count = 10;
      const countdownCanvas = document.querySelector('#countdown');
      const countdownTimer = document.querySelector('#timer-overlay');
      const context = countdownCanvas.getContext('2d');
      countdownCanvas.style.display = 'block';

      const startRecording = () => {
        countdownInterval = setInterval(() => {
          if (count === 0) {
            clearInterval(countdownInterval);
            countdownCanvas.style.display = 'none';
            mediaRecorder.start();
            document.querySelector('#start').disabled = true;
            document.querySelector('#stop').disabled = false;

            const startTime = Date.now();
            const recordingTimeLimit = 30000; // 30 Sekunden in Millisekunden
            const updateTimer = () => {
              const elapsedTime = Date.now() - startTime;
              const remainingTime = Math.max(recordingTimeLimit - elapsedTime, 0);
              const seconds = Math.floor(remainingTime / 1000);
              countdownTimer.textContent = seconds;
              if (remainingTime > 0) {
                requestAnimationFrame(updateTimer);
              } else {
                mediaRecorder.stop();
                document.querySelector('#start').disabled = false;
                document.querySelector('#stop').disabled = true;
                stream.getTracks().forEach(track => track.stop());
                document.querySelector('#preview').srcObject = null;
              }
            };
            updateTimer();
          } else {
            context.clearRect(0, 0, countdownCanvas.width, countdownCanvas.height);
            context.font = '48px Arial';
            context.fillStyle = 'white';
            context.textAlign = 'center';
            context.textBaseline = 'middle';
            context.fillText(count, countdownCanvas.width / 2, countdownCanvas.height / 2);
            count--;
          } 
        }, 1000);
      };

      startRecording();
    })
    .catch(error => console.error('Error:', error));
});

document.querySelector('#stop').addEventListener('click', () => {
  mediaRecorder.stop();
  document.querySelector('#start').disabled = false;
  document.querySelector('#stop').disabled = true;
  stream.getTracks().forEach(track => track.stop());
  document.querySelector('#preview').srcObject = null;
});

function generateUniqueFileName() {
  // URL Parameter auslesen
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get('id');

  // Aktuellen Zeitstempel und zufällige Zeichenkette generieren
  const timestamp = new Date().getTime();
  const randomString = Math.random().toString(36).substring(2, 8);
  
  // Wenn die ID vorhanden ist, wird sie dem Dateinamen vorangestellt
  if (id) {
    return `${id}_${timestamp}_${randomString}.webm`;
  }
  
  // Ansonsten wird der Dateiname wie zuvor generiert
  return `${timestamp}_${randomString}.webm`;
}


mdc.autoInit();