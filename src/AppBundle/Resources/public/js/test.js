function Rectangle(data) {
    this.w = data.w;
    this.h = data.h;
}

Rectangle.prototype.getArea = function () {
    return this.w * this.h;
};

function Iterator() {
    this.forEach = function (collection, iterate) {
        var index = -1;

        while (++index < collection.length) {
            if (iterate(collection[index]) === false) {
                break;
            }
        }

        return collection;
    };

    this.build = function (collection, construct) {
        var index = -1,
            result = [];

        while (++index < collection.length) {
            result.push(new construct(collection[index]));
        }

        return result;
    };

    this.filter = function (collection, predicate) {
        var index = -1,
            resIndex = 0,
            result = [];

        while (++index < collection.length) {
            var value = collection[index];

            if (predicate(value)) {
                result[resIndex++] = value;
            }
        }

        return result;
    }
}

var params = [
    {
        w: 1,
        h: 1
    },
    {
        w: 2,
        h: 2
    },
    {
        w: 3,
        h: 3
    },
    {
        w: 4,
        h: 4
    }
];

var iterator = new Iterator();

var collection = iterator.build(params, Rectangle);

collection = iterator.filter(collection, function (object) {
    return object.w > 2 && object.h > 2;
});
console.log(collection);
/*iterator.forEach(collection, function (object) {
    if (object.getArea() > 4) {
        return false;
    }
    console.log(object, object.getArea());
});*/
