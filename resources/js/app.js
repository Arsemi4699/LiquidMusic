import "./bootstrap";

import "../sass/app.scss";

function timeFormat(time) {
    let hour = Math.floor(time / 3600);
    let min = Math.floor((time - hour * 3600) / 60);
    let sec = Math.floor(time - hour * 3600 - min * 60);
    return hour + ":" + min + ":" + sec;
}
function setURLMENU(element, id) {
    let hrefELM = element.getAttribute("href");
    let split_href = hrefELM.split("/");
    let new_href = "";
    if (split_href.length) {
        split_href[split_href.length - 1] = id;
        for (let i = 0; i < split_href.length; i++) {
            if (split_href[i] === ":") {
                new_href += "/";
            }
            if (i > 0) {
                new_href += "/" + split_href[i];
            } else {
                new_href += split_href[i];
            }
        }
        element.setAttribute("href", new_href);
    }
}

class MusicPlayer {
    PlayerContainer;
    playerSlider;
    soundSlider;
    totalTime;
    currentTime;
    audio;
    prevBtn;
    nextBtn;
    file_src;
    file_duration;
    isPlaying;
    playBtn;
    isSeeking = false;
    speaker;
    SwapUpGStartY;
    SwapUpGEndY;
    miniPanel = false;
    Sec_PlayerContainer;
    Sec_playerSlider;
    Sec_soundSlider;
    Sec_totalTime;
    Sec_currentTime;
    Sec_LikeBtn;
    Sec_NextBtn;
    Sec_plistBtn;
    Sec_ModeBtn;
    Sec_PrevBtn;
    liked;
    mode;
    musicId;
    constructor(file_src, file_duration, liked, musicId, mode) {
        this.hidePopMenu();

        this.liked = liked;
        this.musicId = musicId;
        this.mode = mode;

        this.PlayerContainer = document.getElementById("player__container");
        this.playerSlider = document.getElementById("player__slider");
        this.soundSlider = document.getElementById("sound__slider");
        this.totalTime = document.getElementById("player__totalTime");
        this.currentTime = document.getElementById("player__currentTime");
        this.playBtn = document.getElementById("play__btn");
        this.speaker = document.getElementById("sound__speaker");

        this.Sec_PlayerContainer = document.getElementById(
            "sec__player__container",
        );
        this.Sec_playerSlider = document.getElementById("sec__player__slider");
        this.Sec_soundSlider = document.getElementById("sec__sound__slider");
        this.Sec_totalTime = document.getElementById("sec__player__totalTime");
        this.Sec_currentTime = document.getElementById(
            "sec__player__currentTime",
        );
        this.Sec_LikeBtn = document.getElementById("sec__like__btn");
        this.Sec_NextBtn = document.getElementById("sec__next__btn");
        this.Sec_plistBtn = document.getElementById("sec__plist__btn");
        this.Sec_ModeBtn = document.getElementById("sec__mode__btn");
        this.Sec_PrevBtn = document.getElementById("sec__prev__btn");
        this.Sec_playerSlider.setAttribute("max", this.file_duration);

        if (this.liked) {
            this.Sec_LikeBtn.classList.remove("bi-heart");
            this.Sec_LikeBtn.classList.add("bi-heart-fill");
        }
        this.changeModeIcon();

        this.audio = new Audio();
        this.file_src = file_src;
        this.file_duration = file_duration;
        this.savedMusicVolume();
        this.isPlaying = false;
        this.fetchMusicFromUrl();
        this.currentTime.innerHTML = timeFormat(0);
        this.Sec_currentTime.innerHTML = timeFormat(0);
        this.totalTime.innerHTML = timeFormat(this.file_duration);
        this.Sec_totalTime.innerHTML = timeFormat(this.file_duration);
        this.Sec_playerSlider.value = 0;
        this.playerSlider.value = 0;
        this.updateMusicPlayerSlider();
        this.updateMusicSoundSlider();
        this.audio.addEventListener("timeupdate", (e) => {
            this.updateProgressPerSec(e);
            if (this.audio.ended) {
                dispatchEvent(new Event("PPR"));
                setTimeout(() => {
                    this.currentTime.innerHTML = timeFormat(0);
                    this.Sec_currentTime.innerHTML = timeFormat(0);
                    this.playerSlider.value = 0;
                    this.Sec_playerSlider.value = 0;
                    this.totalTime.innerHTML = timeFormat(this.file_duration);
                    this.Sec_totalTime.innerHTML = timeFormat(
                        this.file_duration,
                    );
                    this.updateMusicPlayerSlider();
                    this.updateMusicSoundSlider();
                }, 50);
            }
        });

        this.Sec_NextBtn.addEventListener("click", () => {
            dispatchEvent(new Event("NextMusic"));
        });
        this.Sec_PrevBtn.addEventListener("click", () => {
            dispatchEvent(new Event("PrevMusic"));
        });
        this.Sec_LikeBtn.addEventListener("click", () => {
            dispatchEvent(new Event("likeDislikeMusic"));
            if (this.liked) this.liked = false;
            else this.liked = true;

            this.Sec_LikeBtn.classList.toggle("bi-heart");
            this.Sec_LikeBtn.classList.toggle("bi-heart-fill");
        });
        this.Sec_ModeBtn.addEventListener("click", () => {
            dispatchEvent(new Event("changeMode"));
            this.mode += 1;
            this.changeModeIcon();
        });

        let isTouchableDevice =
            "ontouchstart" in window ||
            navigator.maxTouchPoints > 0 ||
            navigator.msMaxTouchPoints > 0;
        if (isTouchableDevice) {
            this.PlayerContainer.addEventListener("touchstart", (e) => {
                this.SwapUpGStartY = e.touches[0].clientY;
            });
            this.PlayerContainer.addEventListener("touchmove", function (e) {
                e.preventDefault();
            });
            this.PlayerContainer.addEventListener("touchend", (e) => {
                this.SwapUpGEndY = e.changedTouches[0].clientY;
                this.handleSwipe();
            });

            this.playerSlider.addEventListener(
                "touchstart",
                () => {
                    this.isSeeking = true;
                },
                { passive: true },
            );
            this.Sec_playerSlider.addEventListener(
                "touchstart",
                () => {
                    this.isSeeking = true;
                },
                { passive: true },
            );
            this.playerSlider.addEventListener(
                "touchend",
                (e) => {
                    let touch = e.changedTouches[0];
                    let offsetX;
                    offsetX =
                        touch.clientX -
                        this.playerSlider.getBoundingClientRect().left;
                    this.audio.currentTime =
                        (offsetX / this.playerSlider.clientWidth) *
                        this.audio.duration;
                    this.isSeeking = false;
                },
                { passive: true },
            );
            this.Sec_playerSlider.addEventListener(
                "touchend",
                (e) => {
                    let touch = e.changedTouches[0];
                    let offsetX;
                    offsetX =
                        touch.clientX -
                        this.Sec_playerSlider.getBoundingClientRect().left;
                    this.audio.currentTime =
                        (offsetX / this.Sec_playerSlider.clientWidth) *
                        this.audio.duration;
                    this.isSeeking = false;
                },
                { passive: true },
            );
        } else {
            // For non-touch devices
            this.playerSlider.addEventListener("mousedown", () => {
                this.isSeeking = true;
            });
            this.Sec_playerSlider.addEventListener("mousedown", () => {
                this.isSeeking = true;
            });
            this.playerSlider.addEventListener("click", (e) => {
                this.audio.currentTime =
                    (e.offsetX / this.playerSlider.clientWidth) *
                    this.audio.duration;
                this.isSeeking = false;
            });
            this.Sec_playerSlider.addEventListener("click", (e) => {
                this.audio.currentTime =
                    (e.offsetX / this.Sec_playerSlider.clientWidth) *
                    this.audio.duration;
                this.isSeeking = false;
            });
        }
        this.soundSlider.addEventListener("input", () => {
            console.log(this.file_duration);
            this.audio.volume = this.soundSlider.value / 100;
            localStorage.setItem("audioVolume", this.audio.volume);
            this.updateMusicSoundSlider();
        });
    }
    mountNewData(file_src, file_duration, liked, musicId, mode) {
        this.hidePopMenu();

        this.liked = liked;
        this.musicId = musicId;
        this.mode = mode;

        if (this.liked) {
            this.Sec_LikeBtn.classList.remove("bi-heart");
            this.Sec_LikeBtn.classList.add("bi-heart-fill");
        } else {
            this.Sec_LikeBtn.classList.remove("bi-heart-fill");
            this.Sec_LikeBtn.classList.add("bi-heart");
        }
        this.changeModeIcon();

        this.file_src = file_src;
        this.file_duration = file_duration;
        this.isPlaying = false;
        this.savedMusicVolume();
        this.fetchMusicFromUrl();
        this.updateMusicPlayerSlider();
        this.updateMusicSoundSlider();
        this.currentTime.innerHTML = timeFormat(0);
        this.Sec_currentTime.innerHTML = timeFormat(0);
        this.totalTime.innerHTML = timeFormat(this.file_duration);
        this.Sec_totalTime.innerHTML = timeFormat(this.file_duration);
        this.playerSlider.value = 0;
        this.Sec_playerSlider.value = 0;
        setTimeout(() => {
            dispatchEvent(new Event("MountedOnPlayer"));
        }, 500);
    }
    changeModeIcon() {
        if (this.mode > 3) this.mode = 0;

        if (this.Sec_ModeBtn.classList.contains("bi-arrow-clockwise"))
            this.Sec_ModeBtn.classList.remove("bi-arrow-clockwise");

        if (this.Sec_ModeBtn.classList.contains("bi-music-note"))
            this.Sec_ModeBtn.classList.remove("bi-music-note");

        if (this.Sec_ModeBtn.classList.contains("bi-music-note-list"))
            this.Sec_ModeBtn.classList.remove("bi-music-note-list");

        if (this.Sec_ModeBtn.classList.contains("bi-shuffle"))
            this.Sec_ModeBtn.classList.remove("bi-shuffle");

        if (this.mode == 0)
            this.Sec_ModeBtn.classList.add("bi-music-note");
        else if (this.mode == 1)
            this.Sec_ModeBtn.classList.add("bi-arrow-clockwise");
        else if (this.mode == 2)
            this.Sec_ModeBtn.classList.add("bi-music-note-list");
        else if (this.mode == 3)
            this.Sec_ModeBtn.classList.add("bi-shuffle");
    }
    savedMusicVolume() {
        let savedVolume = localStorage.getItem("audioVolume");
        if (savedVolume) {
            this.audio.volume = savedVolume;
            this.soundSlider.value = savedVolume * 100;
        } else {
            this.audio.volume = 1;
            this.soundSlider.value = 100;
        }
    }
    updateProgressPerSec(e) {
        if (!this.isSeeking) {
            this.playerSlider.value = e.srcElement.currentTime;
            this.Sec_playerSlider.value = e.srcElement.currentTime;
        }
        this.currentTime.innerHTML = timeFormat(e.srcElement.currentTime);
        this.Sec_currentTime.innerHTML = timeFormat(e.srcElement.currentTime);
        if (this.playerSlider.max != e.srcElement.duration) {
            this.totalTime.innerHTML = timeFormat(this.file_duration);
            this.playerSlider.max = e.srcElement.duration;
        }
        if (this.Sec_playerSlider.max != e.srcElement.duration) {
            this.Sec_totalTime.innerHTML = timeFormat(this.file_duration);
            this.Sec_playerSlider.max = e.srcElement.duration;
        }
        this.updateMusicPlayerSlider();
        this.updateMusicSoundSlider();
    }
    updateMusicPlayerSlider() {
        const progress = (this.playerSlider.value / this.file_duration) * 100;
        this.playerSlider.style.background = `linear-gradient(to right, #068fff ${progress}%, #eeeeee ${progress}%)`;
        this.Sec_playerSlider.style.background = `linear-gradient(to right, #068fff ${progress}%, #eeeeee ${progress}%)`;
    }
    updateMusicSoundSlider() {
        const progress = (this.soundSlider.value / this.soundSlider.max) * 100;
        if (progress > 50) {
            if (this.speaker.classList.contains("bi-volume-down"))
                this.speaker.classList.remove("bi-volume-down");
            if (this.speaker.classList.contains("bi-volume-mute"))
                this.speaker.classList.remove("bi-volume-mute");
            this.speaker.classList.add("bi-volume-up");
        }
        if (progress > 0 && progress <= 50) {
            if (this.speaker.classList.contains("bi-volume-up"))
                this.speaker.classList.remove("bi-volume-up");
            if (this.speaker.classList.contains("bi-volume-mute"))
                this.speaker.classList.remove("bi-volume-mute");
            this.speaker.classList.add("bi-volume-down");
        }
        if (progress == 0) {
            if (this.speaker.classList.contains("bi-volume-up"))
                this.speaker.classList.remove("bi-volume-up");
            if (this.speaker.classList.contains("bi-volume-down"))
                this.speaker.classList.remove("bi-volume-down");
            this.speaker.classList.add("bi-volume-mute");
        }
        this.soundSlider.style.background = `linear-gradient(to right, #068fff ${progress}%, #eeeeee ${progress}%)`;
    }
    fetchMusicFromUrl() {
        fetch(this.file_src, {
            method: "GET",
            headers: {
                "Accept-Ranges": "bytes",
            },
        })
            .then((response) => {
                if (response.status === 200) return response.blob();
                else throw new console.error("can't fetch file");
            })
            .then((blob) => {
                this.audio.src = URL.createObjectURL(blob);
            });
    }
    hidePopMenu() {
        if (this.miniPanel) {
            document.getElementById("MiniPop").style = "visibility: hidden";
            this.miniPanel = false;
        }
    }
    showPopMenu() {
        if (!this.miniPanel && window.innerWidth < 992) {
            let hrefPlist = this.Sec_plistBtn.getAttribute("href");
            let split_href = hrefPlist.split("/");
            let new_href = "";
            if (split_href.length) {
                split_href[split_href.length - 1] = this.musicId;
                for (let i = 0; i < split_href.length; i++) {
                    if (split_href[i] === ":") {
                        new_href += "/";
                    }
                    if (i > 0) {
                        new_href += "/" + split_href[i];
                    } else {
                        new_href += split_href[i];
                    }
                }
                this.Sec_plistBtn.setAttribute("href", new_href);
            }

            let rect = document
                .getElementById("player__container")
                .getBoundingClientRect();
            document.getElementById("popUpContainer").style =
                "bottom:" + (window.innerHeight - rect.top) + "px;";
            document.getElementById("MiniPop").style = "visibility: visible";
            this.miniPanel = true;
        }
    }
    handleSwipe() {
        const swipeThreshold = 80;
        const swipeDistance = this.SwapUpGStartY - this.SwapUpGEndY;

        if (swipeDistance > 0) {
            if (!this.miniPanel && swipeDistance > swipeThreshold) {
                this.showPopMenu();
            }
        } else {
            if (this.miniPanel && swipeDistance < -1 * (swipeThreshold - 10)) {
                this.hidePopMenu();
            }
        }
    }
}

function ShowMenu(locx, locy, id) {
    contextMenu.style.left = locx + "px";
    contextMenu.style.top = locy + "px";
    contextMenu.style.visibility = "visible";
    let CMAL = document.getElementById("contextMenuAddL");
    let CMR = document.getElementById("contextMenuReport");
    setURLMENU(CMAL, id);
    setURLMENU(CMR, id);
    targetID = id;
    document.addEventListener("click", () => {
        contextMenu.style.visibility = "hidden";
    });
}
var targetID = -1;
var musicPlayer = null;
var lastPointerX;
var lastPointerY;
var contextMenu;

document.addEventListener("livewire:initialized", () => {
    document.addEventListener("player-updated", (e) => {
        setTimeout(() => {
            if (musicPlayer == null) {
                musicPlayer = new MusicPlayer(
                    e.detail[0],
                    e.detail[1],
                    e.detail[2],
                    e.detail[3],
                    e.detail[4],
                );
            } else {
                musicPlayer.mountNewData(
                    e.detail[0],
                    e.detail[1],
                    e.detail[2],
                    e.detail[3],
                    e.detail[4],
                );
            }
            musicPlayer.updateMusicPlayerSlider();
            musicPlayer.updateMusicSoundSlider();
        }, 100);
    });
    document.addEventListener("pause-play-music", (e) => {
        if (e.detail[0]) {
            musicPlayer.audio.play();
        } else {
            musicPlayer.audio.pause();
        }
        musicPlayer.updateMusicPlayerSlider();
        musicPlayer.updateMusicSoundSlider();
    });

    document.addEventListener("more-options", (e) => {
        setTimeout(() => {
            ShowMenu(lastPointerX, lastPointerY, e.detail[0]);
        }, 50);
    });
});

document.addEventListener("livewire:navigated", () => {
    contextMenu = document.getElementById("contextMenu");
    Array.from(document.getElementsByClassName("ItIsAMusic")).forEach(
        (element) => {
            element.addEventListener(
                "contextmenu",
                (ev) => {
                    ev.preventDefault();
                    let rect = element.getBoundingClientRect();
                    lastPointerX =
                        ev.offsetX > window.innerWidth - contextMenu.offsetWidth
                            ? window.innerWidth - contextMenu.offsetWidth
                            : ev.offsetX;
                    lastPointerY =
                        ev.offsetY >
                            window.innerHeight - contextMenu.offsetHeight
                            ? window.innerHeight - contextMenu.offsetHeight
                            : ev.offsetY;
                    lastPointerX += rect.left;
                    lastPointerY += rect.top;
                    return false;
                },
                false,
            );
        },
    );
    document.getElementById("contextMenuAddQ").addEventListener("click", () => {
        if (targetID != -1) {
            let addMusicOnQ = new CustomEvent("addMusicOnQ", {
                detail: { newID: targetID },
            });
            dispatchEvent(addMusicOnQ);
            targetID = -1;
        }
    });
});
