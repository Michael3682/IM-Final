const canvas = document.getElementById('canvas')
const c = canvas.getContext('2d')
const balls = []
const width = window.innerWidth
const height = window.innerHeight
canvas.width = width
canvas.height = height

window.addEventListener('resize', () => {
    canvas.width = width
    canvas.height = height
})

const rotate = (velocity, angle) => ({
    x: velocity.x * Math.cos(angle) - velocity.y * Math.sin(angle),
    y: velocity.x * Math.sin(angle) + velocity.y * Math.cos(angle)
})

const resolveCollision = (particle, otherParticle) => {
    const xVelocityDiff = particle.velx - otherParticle.velx
    const yVelocityDiff = particle.vely - otherParticle.vely
    const xDist = otherParticle.x - particle.x
    const yDist = otherParticle.y - particle.y

    if (!(xVelocityDiff * xDist + yVelocityDiff * yDist >= 0)) return
    
    const angle = -Math.atan2(otherParticle.y - particle.y, otherParticle.x - particle.x)
    const m1 = particle.mass
    const m2 = otherParticle.mass
    const u1 = rotate({x: particle.velx, y: particle.vely}, angle)
    const u2 = rotate({x: otherParticle.velx, y: otherParticle.vely}, angle)
    const v1 = { x: u1.x * (m1 - m2) / (m1 + m2) + u2.x * 2 * m2 / (m1 + m2), y: u1.y }
    const v2 = { x: u2.x * (m1 - m2) / (m1 + m2) + u1.x * 2 * m2 / (m1 + m2), y: u2.y }
    const V1 = rotate(v1, -angle)
    const V2 = rotate(v2, -angle)

    particle.velx = V1.x
    particle.vely = V1.y

    otherParticle.velx = V2.x
    otherParticle.vely = V2.y
}

class Ball {
    constructor(size) {
        this.x = Math.floor(Math.random() * (width - (size * 2)) + size)
        this.y = Math.floor(Math.random() * (height - (size * 2)) + size)
        this.velx = Math.floor(Math.random() * 2) + 2
        this.vely = Math.floor(Math.random() * 2) + 2
        this.size = size
        this.mass = 1
        this.color = `rgb(0, 204, 255)`
    }
    update() {
        if (this.x + this.size >= width || this.x - this.size <= 0) {
            this.velx = -this.velx
        }
        if (this.y + this.size >= height || this.y - this.size <= 0) {
            this.vely = -this.vely
        }
        this.x += this.velx
        this.y += this.vely
    }
    draw() {
        c.beginPath()
        c.fillStyle = this.color
        c.arc(this.x, this.y, this.size, 0, 2 * Math.PI)
        c.fill()
    }
    checkCollision(balls) {
        for(let i = 0; i < balls.length; i++) {
            if(balls[i] === this) continue

            const x = this.x - balls[i].x
            const y = this.y - balls[i].y
            const d = Math.sqrt(x*x + y*y)

            if(d <= balls[i].size + this.size) {
                resolveCollision(this, balls[i])
            }
        }
    }
}

function loop() {
    for (let i = 0; i < balls.length; i++) {
        balls[i].draw()
        balls[i].update()
        balls[i].checkCollision(balls)
    }

    c.fillStyle = 'rgb(0, 0, 0, 0.3)'
    c.fillRect(0, 0, width, height)
    requestAnimationFrame(loop)
}

while (balls.length < 30) {
    const ball = new Ball(Math.floor(Math.random() * 10))
    balls.push(ball)
}

loop()