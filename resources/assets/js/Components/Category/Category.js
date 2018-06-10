import React, { Component, Fragment } from 'react';
import Axios from 'axios';

import Article from '../Articles/Article';
import Pagination from '../Pagination/Pagination';

import { apiUrl } from '../../Helpers/index';

export default class Category extends Component {
    constructor (props) {
        super();

        this.state = {};
        this.props = props;
    }

    componentWillMount() {
        this.getArticles();
    }

    getArticles(page = 1) {
        Axios.get(`${apiUrl}category/${this.props.match.params.id}?page=${page}`)
            .then(response => {
                this.setState({
                    category: response.data
                });
            })
            .catch(error => console.log(error))
    }

    render() {
        const category = this.state.category;
        let Articles = null;
        let PaginationElement = null;

        if (category) {
            Articles = category.articles.map((article, index) => (
                <Article key={article.id} article={article}/>
            ));

            PaginationElement = <Pagination activePage={category.currentPage} pagination={category.countPages} callback={this.getArticles.bind(this)}/>
        }

        return(
            <div className="category">
                { category ?
                    (<Fragment>
                        <div className="category__title">
                            <span>{category.category_name}</span>
                        </div>
                        <div className="category__articles">
                            {Articles}
                        </div>
                        <div className="category__pagination">
                            {PaginationElement}
                        </div>
                    </Fragment>) :
                    ( <span>Loading...</span>)
                }
            </div>
        );
    }
}