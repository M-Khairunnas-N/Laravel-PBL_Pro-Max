<style>
        /* Control feature layout */
        div.dt-container {
            position: relative;
            width: 100%;
        }

        div.dt-container div.dt-layout-row:first-child {
            display: grid;
            width: 100%;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            grid-gap: 1em;
            padding: 1rem 0;
        }

        div.dt-container div.dt-layout-row:last-child {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            padding: 1rem 0;
        }

        div.dt-container div.dt-layout-row:first-child div.dt-layout-cell.dt-start:first-child {
            grid-column: span 4 / span 4;
            align-self: center
        }

        div.dt-container div.dt-layout-row:last-child div.dt-layout-cell.dt-end {
            display: flex;
            justify-content: end;
            align-items: center;
        }

        /* div.dt-layout-cell.dt-start div.dt-info {
                        text-align: left;
                    } */

        /* div.dt-layout-cell table tbody tr td div {
                        text-align: left !important;
                    } */

        div.dt-container div.dt-layout-cell.dt-end {
            display: flex;
            justify-content: flex-start;
            width: 100%;
        }

        div.dt-container div.dt-layout-cell.dt-end {
            text-align: right;
        }

        div.dt-container div.dt-layout-cell:empty {
            display: none;
        }

        div.dt-container .dt-search input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 5px;
            background-color: transparent;
            color: inherit;
            margin-left: 3px;
        }

        div.dt-container .dt-search{
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        /* div.dt-container select.dt-length{
            width: 100px;
        } */
        
        div.dt-container .dt-input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding-right: 25px;
            padding-left: 10px;
            margin-right: 5px;
            background-color: transparent;
            color: inherit;
        }

        div.dt-container select.dt-input {

        }

        div.dt-container .dt-paging {
            /* background-color: #ffffff !important; */
            padding: 0.75rem;
            border-radius: 0.75rem
        }

        div.dt-container .dt-paging .dt-paging-button {
            box-sizing: border-box;
            display: inline-block;
            width: 2.5em;
            height: 2.5em;
            margin-left: 0.5em;
            text-align: center;
            text-decoration: none !important;
            cursor: pointer;
            color: inherit !important;
            border: 1px solid rgb(209 213 219);
            border-radius: 0.5em;
        }

        div.dt-container .dt-paging .dt-paging-button.current,
        div.dt-container .dt-paging .dt-paging-button.current:hover {
            color: #0B1215;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.5em;
            background-color: #E8F1FF;
            background: -webkit-gradient(linear,
                    left top,
                    left bottom,
                    color-stop(0%, rgba(230, 230, 230, 0.05)),
                    color-stop(100%, #E8F1FF));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Chrome10+,Safari5.1+ */
            background: -moz-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* FF3.6+ */
            background: -ms-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* IE10+ */
            background: -o-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Opera 11.10+ */
            background: linear-gradient(to bottom,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* W3C */
        }

        div.dt-container .dt-paging .dt-paging-button.disabled,
        div.dt-container .dt-paging .dt-paging-button.disabled:hover,
        div.dt-container .dt-paging .dt-paging-button.disabled:active {
            cursor: default;
            color: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid transparent;
            background: transparent;
            box-shadow: none;
        }

        div.dt-container .dt-paging .dt-paging-button:hover {
            color: #0B1215;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.5em;
            background-color: #E8F1FF;
            background: -webkit-gradient(linear,
                    left top,
                    left bottom,
                    color-stop(0%, rgba(230, 230, 230, 0.05)),
                    color-stop(100%, #E8F1FF));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Chrome10+,Safari5.1+ */
            background: -moz-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* FF3.6+ */
            background: -ms-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* IE10+ */
            background: -o-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Opera 11.10+ */
            background: linear-gradient(to bottom,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* W3C */
        }

        div.dt-container .dt-paging .dt-paging-button:active {
            color: #0B1215;
            border: 1px solid rgba(0, 0, 0, 0.3);
            background-color: #E8F1FF;
            background: -webkit-gradient(linear,
                    left top,
                    left bottom,
                    color-stop(0%, rgba(230, 230, 230, 0.05)),
                    color-stop(100%, #E8F1FF));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Chrome10+,Safari5.1+ */
            background: -moz-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* FF3.6+ */
            background: -ms-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* IE10+ */
            background: -o-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Opera 11.10+ */
            background: linear-gradient(to bottom,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* W3C */
        }

        div.dt-container .dt-paging .ellipsis {
            padding: 0 1em;
            display: flex;
            justify-content: center;
            align-items: center
        }

        div.dt-container .dt-length,
        div.dt-container .dt-search,
        div.dt-container .dt-info,
        div.dt-container .dt-processing,
        div.dt-container .dt-paging {
            color: #0B1215;
        }

        div.dt-container .dt-info {
            padding: 1rem 0;
        }

        div.dt-container .dataTables_scroll {
            clear: both;
        }

        div.dt-container .dataTables_scroll div.dt-scroll-body {
            -webkit-overflow-scrolling: touch;
        }

        div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>th,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>td,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>th,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>td {
            vertical-align: middle;
        }

        div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>th>div.dataTables_sizing,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>td>div.dataTables_sizing,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>th>div.dataTables_sizing,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>td>div.dataTables_sizing {
            height: 0;
            overflow: hidden;
            margin: 0 !important;
            padding: 0 !important;
        }

        div.dt-container.dt-empty-footer tbody>tr:last-child>* {
            border-bottom: 1px solid rgba(0, 0, 0, 0.3);
        }

        div.dt-container.dt-empty-footer .dt-scroll-body {
            border-bottom: 1px solid rgba(0, 0, 0, 0.3);
        }

        div.dt-container.dt-empty-footer .dt-scroll-body tbody>tr:last-child>* {
            border-bottom: none;
        }

        div.dt-container div.dt-layout-cell.dt-end {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        div.dt-container.dt-empty-footer {
            width: auto;
        }

        div.dt-layout-row.dt-layout-table {
            overflow: auto;
        }

        @media screen and (max-width: 1280px) {
            div.dt-container {
                width: fit-content;
            }

            div.dt-container div.dt-layout-row:first-child {
                display: grid;
                width: 100%;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                grid-gap: 1em;
                padding: 1rem 0;
            }

            div.dt-container div.dt-layout-row:last-child {
                display: flex;
                flex-direction: column;
            }

            div.dt-container div.dt-layout-row:first-child div.dt-layout-cell.dt-start:first-child {
                grid-column: span 2 / span 2;
                align-self: center
            }

            div.dt-container div.dt-layout-row:last-child div.dt-layout-cell.dt-end {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            div.dt-layout-cell.dt-start div.dt-info {
                text-align: center;
            }
        }


        @media screen and (max-width: 768px) {}

        @media screen and (max-width: 640px) {

            div.dt-container {
                width: 100%;
            }

            div.dt-container div.dt-layout-row:first-child {
                display: flex;
                flex-direction: column
            }

            div.dt-container div.dt-layout-row:last-child {
                display: flex;
                flex-direction: column;
                width: max-content
            }

            div.dt-container div.dt-layout-row div.dt-layout-cell {
                width: 100% !important;
            }

            div.dt-container div.dt-layout-row div.dt-layout-cell div.dt-start {
                width: 100% !important;
            }

            div.dt-container div.dt-layout-row div.dt-layout-cell.dt-end {
                width: 100% !important;
            }

            div.dt-layout-cell.dt-start div.dt-info {
                text-align: left;
            }

            .dt-container .dt-length,
            .dt-container .dt-search {
                float: none;
                text-align: center;
            }

            .dt-container .dt-search {
                margin-top: 0.5em;
            }
        }

        */ *[dir="rtl"] table.dataTable thead th,
        *[dir="rtl"] table.dataTable thead td,
        *[dir="rtl"] table.dataTable tfoot th,
        *[dir="rtl"] table.dataTable tfoot td {
            text-align: left;
        }

        *[dir="rtl"] table.dataTable th.dt-type-numeric,
        *[dir="rtl"] table.dataTable th.dt-type-date,
        *[dir="rtl"] table.dataTable td.dt-type-numeric,
        *[dir="rtl"] table.dataTable td.dt-type-date {
            text-align: left;
        }

        *[dir="rtl"] div.dt-container div.dt-layout-cell.dt-start {
            text-align: left;
        }

        *[dir="rtl"] div.dt-container div.dt-layout-cell.dt-end {
            text-align: left;
        }

        *[dir="rtl"] div.dt-container div.dt-search input {
            margin: 0 3px 0 0;
        }
    </style>
