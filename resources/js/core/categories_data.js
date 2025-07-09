export const TYPES = ['offer', 'looking', 'both'];
export const WHERE_OPTIONS = [
    {
        id  : 'australia-wide',
        text: 'Australia Wide'
    },
    {
        id  : 'states',
        text: 'States'
    },
    /*{
        id  : 'local-area',
        text: 'Local Area'
    },*/
    /*{
        id  : 'location',
        text: 'Location'
    },*/
    {
        id  : 'suburbs',
        text: 'Suburbs'
    },
    {
        id  : 'radius',
        text: 'Within a Radius'
    }
];

export const STATES = [
    'ACT',
    'QLD',
    'NT',
    'NSW',
    'SA',
    'VIC',
    'TAS',
    'WA'
];

export const SUBURBS = [
    'HMAS CRESWELL',
    'BARTON',
    'AINSLIE',
    'MANUKA',
    'HUGHES',
    'PHILLIP DC',
    'WESTON',
    'TORRENS'
];

export const RADIUS_OPTIONS = [
    5,
    10,
    15,
    25,
    50
];

export const WHEN_OPTIONS = [
    'ongoing',
    'now',
    'flexible',
    'upon-request',
    'range',
    'fixed'
];

export const COST_OPTIONS = [
    'free',
    'range',
    'fixed',
];

export const FREQUENCY_OPTIONS = [
    'hourly',
    'daily',
    'weekly',
    'monthly',
    'yearly'
];

export const EMAIL_PREFERENCES = [
    'daily',
    'weekly',
    'fortnightly',
    'monthly'
];

export default {
    TYPES,
    WHERE_OPTIONS,
    STATES,
    SUBURBS,
    RADIUS_OPTIONS,
    WHEN_OPTIONS,
    COST_OPTIONS,
    FREQUENCY_OPTIONS,
    EMAIL_PREFERENCES
};
