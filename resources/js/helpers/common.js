export function calculateTime(time, component) {
    let convertedTime = new Date(time);
    let now = new Date();
    let timestamp = now - convertedTime;
    if (timestamp > 1000) {

        let seconds = toSeconds(now - convertedTime);
        if (seconds > 60) {
            let minutes = toMinutes(seconds);
            if (minutes > 60) {
                let hours = toHours(minutes);
                if (hours > 24) {
                    let dates = toDates(hours);
                    if (dates > 30) {
                        let months = toMonths(dates);
                        if (months > 12) {
                            let years = toYears(months);
                            return Math.round(years) + component.$t('times_ago.year');
                        }
                        return Math.round(months) + component.$t('times_ago.month');
                    }
                    return Math.round(dates) + component.$t('times_ago.date');
                }
                return Math.round(hours) + component.$t('times_ago.hour');
            }
            return Math.round(minutes) + component.$t('times_ago.minute');
        }
        return Math.round(seconds) + component.$t('times_ago.second');
    }
    return component.$t('times_ago.recently');
}

function toYears(months) {
    return months / 12;
}

function toMonths(dates) {
    return dates / 30;
}

function toDates(hours) {
    return hours / 24;
}

function toHours(minutes) {
    return minutes / 60;
}

function toMinutes(seconds) {
    return seconds / 60;
}

function toSeconds(timestamp) {
    return timestamp / 1000;
}