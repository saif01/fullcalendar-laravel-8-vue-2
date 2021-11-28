
let eventGuid = 0
let todayStr = new Date().toISOString().replace(/T.*$/, '') // YYYY-MM-DD of today

export const INITIAL_EVENTS = [
    {
        title  : 'event1',
        start  : '2010-01-01',
    },
    {
        title  : 'event2',
        start  : '2010-01-05',
        end    : '2010-01-07',
    },
    {
        title  : 'event3',
        start  : '2010-01-09T12:30:00',
        allDay : false,
    },
//   {
//     id: createEventId(),
//     title: 'All-day event',
//     start: todayStr
//   },
//   {
//     id: createEventId(),
//     title: 'Timed event',
//     start: todayStr + 'T12:00:00'
//   }
]

export function createEventId() {
  return String(eventGuid++)
}