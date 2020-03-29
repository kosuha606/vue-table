
export default {
    page: 1,
    itemsPerPage: 10,
    itemsPerPageVariants: [10, 20, 30, 40, 50],
    total: 10,
    appendMode: false,
    getOffsetBegin() {
        return (this.page-1)*this.itemsPerPage;
    },
    getOffsetEnd() {
        return (this.page)*this.itemsPerPage;
    },
    pagesCount() {
        return Math.round(this.total/this.itemsPerPage);
    },
    gotoEnd() {

    },
    gotoBegint() {

    },
    gotoPage() {

    },
    nextPage() {

    },
    prevPage() {

    }
}