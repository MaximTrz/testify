const timeFormatting = (time: number) => {
    const minute: number = Math.floor(time / 60);
    const rawSeconds: number = time % 60;
    const seconds = rawSeconds < 10 ? "0" + rawSeconds : rawSeconds;
    const timeString: string = `${minute}:${seconds}`;
    return time > 0 ? timeString : "Время вышло";
};

export default timeFormatting;
