function isUndefined(value) {
    return value === undefined
}

function evaluateGuards(guards, context) {
    const guardsLeft = guards.slice(0) // clone the array so we do not accidentally modify it
    const nextGuard = guardsLeft.shift()
    const {to, from, next, store} = context

    if (isUndefined(nextGuard)) {
        next()
        return false
    }

    nextGuard(
        to,
        from,
        (nextArg) => {
            if (isUndefined(nextArg)) {
                evaluateGuards(guardsLeft, context)
                return
            }
            next(nextArg)
        },
        store
    )
}

module.exports = function(guards, context) {
    if (!Array.isArray(guards)) {
        throw new Error('You must specify an array of guards')
    }

    return evaluateGuards(guards, context)
}
