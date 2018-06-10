import React, { Component } from 'react';
import { Link } from 'react-router-dom';

import './Articles.css';

import Article from './Article';

export default class Category extends Component {
    constructor(props) {
        super();

        this.state = props;
    }

    render() {
        const ArticlesElements = this.state.article.item.map((item, index) => (
            <Article key={index} article={item} />
        ));

        return(
            <div className="category">
                <Link className="category__title" to={'category/' + this.state.article.category_id}>
                    <span>{this.state.article.name}</span>
                </Link>
                <div className="category__articles">
                    {ArticlesElements}
                </div>
            </div>
        );
    }
}