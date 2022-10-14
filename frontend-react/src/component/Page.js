import React, {Component} from "react";
import Pagination from "react-js-pagination";

class Page extends Component {
    constructor(props) {
        super(props);

    }

    handlePageChange(page) {
        this.props.updatePage(page)
    }

    render() {
        return (
            <div>
                <Pagination
                    activePage={this.props.page}
                    itemsCountPerPage={this.props.limit}
                    totalItemsCount={this.props.totalItemsCount}
                    pageRangeDisplayed={5}
                    onChange={this.handlePageChange.bind(this)}
                />
            </div>
        );
    }
}

export default Page