export function useUrlFunc() {
    function getUrlParams(search) {
        if (search == null || search == '' || search == undefined) {
            search = window.location.search;
            if (search == '') {
                return {};
            }
        }

        let hashes = search.slice(search.indexOf('?') + 1).split('&');

        return hashes.reduce((params, hash) => {
            let [key, val] = hash.split('=')
            return Object.assign(params, {
                [key]: val ? decodeURIComponent(val) : ''
            });
        }, {});
    }

    function buildURLQuery(params = {}, searchQuery = null) {
        let qParams;
        if (searchQuery) {
            if (searchQuery === true) {
                searchQuery = window.location.search;
            }

            qParams = {...getUrlParams(searchQuery), ...params};
        } else {
            qParams = params ?? {};
        }

        const esc = encodeURIComponent;
        const query = Object.keys(qParams)
            .map(key => (esc(qParams[key]) === 'undefined' || esc(qParams[key]) == undefined) ? esc(key) : `${esc(key)}=${esc(qParams[key])}`)
            .join('&');

        return query;
    }

    function buildQueryString(params, prevQuery = null) {
        if (!params) {
            return '';
        }

        let query = {};
        for (let key in params) {
            if (params[key]) {
                query[key] = params[key];
            }
        }

        return buildURLQuery(query, prevQuery);
    }

    function pushUrlState(params) {
        const urlQueryParams = getUrlParams();

        if (params) {
            params = {...urlQueryParams, ...params};
            params = Object.entries(params).reduce((acc, [key, value]) => (value ? (acc[key] = value, acc) : acc), {});
        }

        if (!params || Object.keys(params).length === 0) {
            history.pushState(null, null, window.location.pathname);
        } else {
            history.pushState(null, null, `?${buildURLQuery(params)}`)
        }
    }

    return {getUrlParams, buildURLQuery, buildQueryString, pushUrlState}
}
