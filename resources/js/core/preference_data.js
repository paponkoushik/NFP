export const COMMON_DATA = {
    states : [], // it used when - where is states
    suburbs: [], // it used when - where is suburbs
    //local_area     : '', // it used when - where is local-area
    radius_location: '', // it used when - where is radius
    radius         : '', // it used when - where is radius
    when           : '', // ongoing, date-range, fixed-date etc are options
    date           : '', // it used when - when is only date
    from_date      : '', // it used when - when is date-range
    to_date        : '', // it used when - when is date-range
    cost           : '', // no-cost, range, fixed etc are options
    amount         : '', // it used when - cost is fixed
    from_amount    : '', // it used when - cost is range
    to_amount      : '', // it used when - cost is range
    frequency      : '', // it used when - cost is range
    lat            : '',
    long           : '',
    location_id    : '',
};

export const PREFERENCES_DATA = {
    type         : 'looking', // offer, looking, both
    where        : {
        location: 'australia-wide', // australia-wide, states, local-area, suburbs, radius (it used when type is offer or looking)
        ...COMMON_DATA
    },
    where_looking: {
        looking: 'australia-wide', // australia-wide, states, local-area, suburbs, radius (it used when type is both)
        ...COMMON_DATA
    }, // australia-wide, states, local-area, suburbs, radius (it used when type is both)
    where_offer  : {
        offer: 'australia-wide', // australia-wide, states, local-area, suburbs, radius (it used when type is both)
        ...COMMON_DATA
    }, // australia-wide, states, local-area, suburbs, radius (it used when type is both)
    summary      : '',
    category     : '',
    sub_category : '',
    sub1_category: ''
};

export const WHERE_PREFERENCES = {
    location: 'australia-wide', // australia-wide, states, local-area, suburbs, radius (it used when type is offer or looking)
    ...COMMON_DATA
};

export const WHERE_LOOKING_PREFERENCES = {
    looking: 'australia-wide', // australia-wide, states, local-area, suburbs, radius (it used when type is both)
    ...COMMON_DATA
}

export const WHERE_OFFER_PREFERENCES = {
    offer: 'australia-wide', // australia-wide, states, local-area, suburbs, radius (it used when type is both)
    ...COMMON_DATA
}


export default {
    PREFERENCES_DATA,
    WHERE_PREFERENCES,
    WHERE_LOOKING_PREFERENCES,
    WHERE_OFFER_PREFERENCES
};
