export default function useDatatableFunc() {
    function getItemAndMetaData(response) {
        let data = [], meta = {};

        if (response !== undefined && response !== '' && response !== null && typeof response !== 'string') {
            if ('data' in response) {
                data = [...response.data];
                
                if ('meta' in response) {                        
                    meta.total = response.meta.total;
                    meta.per_page = response.meta.per_page;
                    meta.current_page = response.meta.current_page;
                    meta.last_page = response.meta.last_page;
                    meta.next_page_url = response.links.next;
                    meta.prev_page_url = response.links.prev;
                    meta.from = response.meta.from;
                    meta.to = response.meta.to;                
                    meta.limit = meta.per_page
                } else {
                    meta.total = response.total;
                    meta.per_page = response.per_page;
                    meta.current_page = response.current_page;
                    meta.last_page = response.last_page;
                    meta.next_page_url = response.next_page_url;
                    meta.prev_page_url = response.prev_page_url;
                    meta.from = response.from;
                    meta.to = response.to;                
                    meta.limit = meta.per_page
                }
            } else {
                data = [...response]
            }
        }

        return { data, meta };
    };

    return { getItemAndMetaData };
}