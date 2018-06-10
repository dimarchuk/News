import React, { Component } from 'react';

import './Pagination.css';

export default class Pagination extends Component {
    constructor(props) {
        super();

        this.state = {
            pagination: props.pagination,
            isOpenFullPagesList: false
        };

        this.props = props;

        this.onClickHandler = this.onClickHandler.bind(this);
        this.openFullPagesList = this.openFullPagesList.bind(this);
    }

    onClickHandler(event) {
        const numberOfPage = event.target.innerHTML;

        this.props.callback(numberOfPage);
    }

    openFullPagesList() {
        this.setState((prevState) => ({
            isOpenFullPagesList: !prevState.isOpenFullPagesList
        }));
    }

    render() {
        const paginationCount = this.state.pagination;
        let currentPage = this.props.activePage - 1;
        let paginationArray = [];

        for (let i = 1; i <= paginationCount; i++) {
            paginationArray.push(i);
        }

        if (paginationCount <= 5) {
            return (
                <div className="pagination">
                    {
                        paginationArray.map((link, index) => (
                            <button className={'pagination__button ' + (currentPage === index ? 'pagination__button--active': '')}
                                    key={link}
                                    onClick={this.onClickHandler}>{link}</button>
                        ))
                    }
                </div>
            );
        } else {
            let middleLinksArray = paginationArray;
                middleLinksArray.pop();
                middleLinksArray.shift();

            return(
                <div className="pagination">
                    <button className={'pagination__button ' + (currentPage === 0 ? 'pagination__button--active': '')}
                            onClick={this.onClickHandler}>{'1'}</button>
                    <div className="pagination__middle">
                        {
                            this.state.isOpenFullPagesList ? (
                                <div className="pagination__buttons">
                                    {
                                        middleLinksArray.map((link, index) => (
                                            <button
                                                className={'pagination__button ' + (currentPage === index + 1 ? 'pagination__button--active' : '')}
                                                key={link} onClick={this.onClickHandler}>{link}</button>
                                        ))
                                    }
                                </div>
                            ) : (
                                <div className="pagination__dots" onClick={this.openFullPagesList}>
                                    <span className="dot"></span>
                                    <span className="dot"></span>
                                    <span className="dot"></span>
                                </div>
                            )
                        }
                    </div>
                    <button className={'pagination__button ' + (currentPage === paginationCount ? 'pagination__button--active': '')}
                            onClick={this.onClickHandler}>{paginationCount}</button>
                </div>
            );
        }
    }
}